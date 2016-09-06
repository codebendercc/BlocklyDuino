var blocklyEngine = {
    codebender: window.codebender,
    compile: window.codebender.compile,
    arduinoCodeOpen: false,
    arduinoCodeWidth: '100%',
    arduinoCodeAnimationDelay: 500,
    defaultFilename: 'Blockly',
    initialize: function () {
        this.filename = this.defaultFilename;
        this.initializeUI();
        this.initializeCompilerflasher();
        this.eventListeners();
        this.checkFileApis();
    },
    initializeUI: function () {
        this.$textAreaArduino = $('#textarea_arduino');
        this.$toggleArduinoCode = $('#toggle-arduino-code');
        this.$textareaArduino = $('#textarea_arduino');
        this.$serialMonitorToggle = $('#serial_monitor_toggle');
        this.$open = $('#open');
        this.$input = this.$open.find('input');

        var tooltipOptions = {
            placement: 'bottom'
        };

        $('#blockly-controls-container').find('button, select').tooltip(tooltipOptions);
        $('#more-options-container').tooltip(tooltipOptions);
        this.$serialMonitorToggle.tooltip(tooltipOptions);
        this.$toggleArduinoCode.tooltip(tooltipOptions);
    },
    initializeCompilerflasher: function () {
        compilerflasher = new compilerflasher(getFiles);
        compilerflasher.embedded = true;

        /**
         * Redefines compilerflasher's getbin function so that it points at our builder route.
         * @param callback The callback function that hooks into getbin.
         */
        compilerflasher.getbin = function (callback) {
            window.operationInProgress = true;
            var payload = this.generate_payload("binary");
            var cb = this;
            $.post(window.codebender.compilerflasher.utilitiesCompile, payload, function (data) {
                try {
                    var obj = jQuery.parseJSON(data);
                    callback(obj);
                }
                catch (err) {
                    cb.setOperationOutput('<i class="icon-remove"></i> Unexpected error occurred. Try again later.');
                    cb.eventManager.fire('verification_failed', '<i class="icon-remove"></i> Unexpected error occurred. Try again later.');
                }
            }).fail(function () {
                cb.setOperationOutput("Connection to server failed.");
                cb.eventManager.fire('verification_failed', "Connection to server failed.");
            }).always(function () {
                window.operationInProgress = false;
            });
        };

        compilerflasher.on('serial-monitor-connected', function () {
            $('#blockly-tabs').find('a:last').tab('show');
        });
    },
    toggleArduinoCode: function () {
        this.$toggleArduinoCode.tooltip('hide');

        if (this.arduinoCodeOpen) {
            this.$textAreaArduino.css({
                padding: 0
            });
            this.$textAreaArduino.animate({
                width: 0
            }, this.arduinoCodeAnimationDelay);
            this.$toggleArduinoCode.removeClass('active');
            this.arduinoCodeOpen = false;
            return;
        }

        this.updateArduinoCode();
        this.$textAreaArduino.css({
            padding: '5px 30px'
        });
        this.$textAreaArduino.animate({
            width: this.arduinoCodeWidth
        }, this.arduinoCodeAnimationDelay);
        this.$toggleArduinoCode.addClass('active');
        this.arduinoCodeOpen = true;
    },
    updateArduinoCode: function () {
        this.$textareaArduino.val(Blockly.Generator.workspaceToCode('Arduino'));
    },
    eventListeners: function () {
        var self = this;

        this.$serialMonitorToggle.on('click', function () {
            toggle_serial_monitor();
        });

        this.$toggleArduinoCode.on('click', function () {
            self.toggleArduinoCode();
        });

        $("#save-arduino").on('click', function () {
            self.downloadHandler(false);
        });

        $("#save-xml").on('click', function () {
            self.downloadHandler(true);
        });

        this.$input.on('click', function (event) {
            event.stopPropagation();
        });

        this.$open.on('click', function () {
            self.uploadHandler();
        });

        $("#clear").on('click', function () {
            Blockly.mainWorkspace.clear();
            self.filename = self.defaultFilename;
        });

        $("#open-file").on('change', function (event) {
            self.handleFileSelect(event.originalEvent);
        });

        $('#examples').on('click', '.example', function () {
            var example = $(this).attr('data-name');
            $.ajax({
                url: self.codebender.example,
                method: 'POST',
                data: {
                    example: example
                }
            }).done(function (response) {
                if (!response.success) {
                    return;
                }

                self.filename = response.name;
                Blockly.mainWorkspace.clear();
                var xml = window.Blockly.Xml.textToDom(response.code);
                Blockly.Xml.domToWorkspace(Blockly.mainWorkspace, xml);
            }).fail(function () {
            });
        });
    },
    checkFileApis: function () {
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            return;
        }

        this.$open.off('click').removeAttr('href').attr('title', 'File upload disabled. Please update your browser.');
    },
    uploadHandler: function () {
        this.$input.trigger('click');
    },
    handleFileSelect: function (event) {
        var self = this;

        var files = event.target.files;

        if (files.length !== 1) {
            return;
        }

        var file = files[0];
        var reader = new FileReader();

        reader.onload = (function (theFile) {
            return function (event) {
                self.filename = theFile.name.split('.')[0];
                var contents = event.target.result.replace(/.*base64,/, '');
                contents = atob(contents);
                Blockly.mainWorkspace.clear();
                var xml = window.Blockly.Xml.textToDom(contents);
                Blockly.Xml.domToWorkspace(Blockly.mainWorkspace, xml);

                self.$input.val('');
            };
        })(file);

        reader.readAsDataURL(file);
    },
    downloadHandler: function (useXml) {
        var filelist = this.getFiles(useXml);

        var $form = $('<form>');
        $form.attr('action', this.codebender['download']).attr('method', 'post');
        Object.keys(filelist).forEach(function (filename) {
            var $input = $('<input>');
            $input.attr('type', 'hidden').attr('name', filename).attr('value', filelist[filename]);
            $form.append($input);
        });

        $form.appendTo('body').submit().remove();
    },
    getFiles: function (useXml) {
        return this.getBlocklyFilelist(useXml);
    },
    getBlocklyFilelist: function (useXml) {
        var sketch = {};

        if (useXml) {
            sketch[this.filename + '.xml'] = this.getBlocklyWorkspace();
            return sketch;
        }

        sketch[this.filename + '.ino'] = Blockly.Generator.workspaceToCode('Arduino');
        return sketch;
    },
    getBlocklyWorkspace: function () {
        var xmlDom = Blockly.Xml.workspaceToDom(Blockly.mainWorkspace);
        return Blockly.Xml.domToPrettyText(xmlDom);
    }
};

$(function () {
    blocklyEngine.initialize();
});

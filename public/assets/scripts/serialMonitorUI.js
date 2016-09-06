var nsDraggable = {};
nsDraggable.yes = false;
nsDraggable.height = 12;
var remember = {};
remember.mcheight = 0;
remember.cbwidth = 0;
remember.bheight = 0;
remember.theight = 0;
remember.tbottom = 0;
remember.nsdtop = 0;

function toggle_serial_monitor() {
    if ($('#serial_monitor').is(':visible')) {
        close_serial_monitor();
    }
    else {
        open_serial_monitor();
    }
}

function open_serial_monitor() {
    var $serialBtn = $('#serial_btn');
    var $serialMonitor = $('#serial_monitor');
    var $containerTop = $('#container_top');
    var $containerBottom = $('#container_bottom');
    var $nsDraggableHandle = $('#ns_draggable_handle');

    $('#serial_monitor_toggle').addClass('active');

    if ($serialBtn.hasClass('connected')) {
        $containerTop.removeAttr('style');
        $containerBottom.removeAttr('style');
        $nsDraggableHandle.removeAttr('style');
        nsDraggable.yes = false;

        $serialMonitor.removeAttr('style');
        $serialMonitor.removeClass('draggable');
        $serialBtn.find('i').removeClass().addClass('icon-list-alt');
        $serialBtn.find('.text-large').html('Serial Monitor');
        $serialBtn.removeClass('connected');

        resizeSerialOutput();

        return;
    }

    var containerBottomCSS = {
        visibility: 'visible',
        height: remember.bheight
    };
    $containerBottom.css(containerBottomCSS);

    var containerTopCSS = {
        bottom: remember.tbottom
    };
    $containerTop.css(containerTopCSS);

    $serialMonitor.css({
        display: 'block'
    });

    var nsDraggablehandleCSS = {
        display: 'block',
        top: remember.theight + remember.ns_offset
    };
    $nsDraggableHandle.css(nsDraggablehandleCSS);

    nsDraggable.yes = true;

    $serialBtn.find('i').removeClass().addClass('icon-unlink');
    $serialBtn.find('.text-large').html('Disconnect');
    $serialBtn.addClass('connected');

    resizeSerialOutput();
}

function close_serial_monitor() {
    var $serialBtn = $('#serial_btn');
    var $serialMonitor = $('#serial_monitor');

    if (compilerflasher.pluginHandler.connected) {
        compilerflasher.pluginHandler.disconnect();
    }
    $('#serial_monitor_toggle').removeClass('active');

    $('#container_top, #container_bottom, #ns_draggable_handle').removeAttr('style');
    nsDraggable.yes = false;

    $serialMonitor.removeAttr('style');
    $serialBtn.find('i').removeClass().addClass('icon-list-alt');
    $serialBtn.find('.text-large').html('Serial Monitor');
    $serialBtn.removeClass('connected');
}

function resizeSerialOutput() {
    $('#serial_monitor_output').css({
        height: $('#serial-wrapper').height() - $('#user_input').height() - 3
    });
}

function calcNsOffset() {
    return 0;
}

function resizable_elements() {
    var $containerBottom = $('#container_bottom');
    var $containerTop = $('#container_top');
    var $nsDraggableHandle = $('#ns_draggable_handle');
    var $mainContainer = $('#main-container');
    var offset = $containerBottom.offset();

    var nssplitter = function (event, ui) {
        remember.mcheight = $mainContainer.height();
        remember.tbottom = remember.mcheight - ui.position.top;
        remember.bheight = remember.mcheight - ui.position.top - nsDraggable.height;
        $containerBottom.css({
            height: remember.bheight
        });
        $containerTop.css({
            bottom: remember.tbottom
        });
        remember.theight = $containerTop.height();
        remember.nsdtop = ui.position.top;
        resizeSerialOutput();
    };

    remember.mcheight = $mainContainer.height();
    $nsDraggableHandle.draggable({
        axis: 'y',
        containment: [
            0,
            $containerTop.offset().top + remember.mcheight * 0.2,
            $mainContainer.width(),
            remember.mcheight * 0.9
        ],
        drag: nssplitter,
        stop: nssplitter
    });
    remember.bheight = (remember.mcheight / 2) - nsDraggable.height;
    remember.theight = remember.mcheight - remember.bheight - nsDraggable.height;
    remember.tbottom = remember.theight;
    remember.nsdtop = remember.theight + nsDraggable.height;

    $(window).resize(function () {
        var newcbwidth = parseInt($containerBottom.width(), 10);
        offset = $containerBottom.offset();
        remember.cbwidth = newcbwidth;
        remember.ns_offset = calcNsOffset();

        var mainContainerHeight = $mainContainer.height();

        var pernsd = (remember.nsdtop * 100) / remember.mcheight;
        var newnsd = (pernsd * mainContainerHeight) / 100;
        var nsDraggableTopMax = $containerTop.offset().top + mainContainerHeight * 0.2;
        var nsDraggableTopMin = mainContainerHeight * 0.9;
        var expectedHeightBottom = mainContainerHeight - newnsd;
        var minimumHeight = mainContainerHeight - nsDraggableTopMin + $containerTop.offset().top;
        if (expectedHeightBottom < minimumHeight) {
            newnsd -= minimumHeight - expectedHeightBottom;
        }

        var newctb = (mainContainerHeight - newnsd) - remember.ns_offset;
        var newcbh = mainContainerHeight - newnsd - nsDraggable.height - remember.ns_offset;
        $nsDraggableHandle.draggable('option', 'containment', [
            0,
            nsDraggableTopMax,
            $mainContainer.width(),
            nsDraggableTopMin
        ]);
        var nsTop = newnsd + remember.ns_offset;
        remember.bheight = newcbh;
        remember.tbottom = newctb;
        remember.theight = nsTop - remember.ns_offset;
        if (nsDraggable.yes) {
            var containerTopCSS = {
                bottom: newctb
            };
            var containerBottomCSS = {
                height: newcbh
            };
            var nsDraggableHandle = {
                top: nsTop
            };

            if (remember.nsdtop == 0) {
                containerTopCSS.bottom = 212;
                containerBottomCSS.height = 150;
                nsDraggableHandle.top = $containerTop.height() + remember.ns_offset;
            }
            $containerTop.css(containerTopCSS);
            $containerBottom.css(containerBottomCSS);
            $nsDraggableHandle.css(nsDraggableHandle);

            resizeSerialOutput();
        }
    });
}

$(function () {
    remember.ns_offset = calcNsOffset();

    if ($('#container_bottom').length > 0) {
        resizable_elements();
    }
});

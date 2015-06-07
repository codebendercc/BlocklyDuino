// Commit: 8c0f22d2e596c755cadff19fa92e617252f95aa0
// Dev mode disabled
(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
// file: firefox-loader.js
require('./../tools/client-util');

window.CodebenderPlugin = require('./firefox-plugin');

if (!window.CodebenderPlugin) {
  console.warn("No firefox plugin.");
}

},{"./../tools/client-util":3,"./firefox-plugin":2}],2:[function(require,module,exports){
// file: firefox-plugin.js

dbg("Not on chrome");
function PluginPropertyDescriptor(pluginElement, prop) {
  var desc = Object.getOwnPropertyDescriptor(
    Object.getPrototypeOf(pluginElement), prop);

  // Be careful not to evaluate any pluginproperties. Some may have
  // side effects
  if (desc)
    Object.getOwnPropertyNames(desc).forEach(function (pp) {
      if (pp != "value" && true) {
        console.log(prop + '[' + pp + ']');
        this[pp] = pluginElement[pp];
      }
    });
  else
    throw Error("Could not determine property descruptor of plugin property '"
                + prop);

  this.get = function () {return pluginElement[prop];};
  this.set = function (val) {pluginElement[prop] = val;};
}

function prototypeProperties(obj) {
  return Object.getOwnPropertyNames(Object.getPrototypeOf(obj));
}

// Copy the plugin interfacez
function Plugin() {
  // Note that this has typeof 'function' on firefox because it
  // implements [[Call]]
  this.element_ = document.createElement("object");
  this.element_.setAttribute("type", "application/x-codebendercc");
  this.element_.setAttribute("width", "0");
  this.element_.setAttribute("height", "0");
  this.element_.setAttribute("xmlns", "http://www.w3.org/1999/html");

  document.body.appendChild(this.element_);
  this.element_.id = "plugin0";

  prototypeProperties(this.element_).forEach( function (attr) {
    if (typeof this.element_[attr] == 'function') {
      this[attr] = function () {
        var args = Array.prototype.slice.call(arguments);
        return this.element_[attr].apply(this.element_, args);
      }.bind(this);
    } else {
      var descr = new PluginPropertyDescriptor(this.element_, attr);
      Object.defineProperty(this, attr, descr);
    }
  }.bind(this) );

  // if (this.init)
  //   this.init();
  // else
  //   throw Error("Codebendercc plugin not available");
}

function CodebenderPlugin () {
  Plugin.apply(this, Array.prototype.slice(arguments));
  this.getPorts = this.getPortsCb;
  this.availablePorts = this.availablePortsCb;
  this.getFlashResult = this.getFlashResultCb;
  this.probeUSB = this.probeUSBCb;
  this.init = this.initCb;
};

if (typeof Object.create !== 'function') {
  Object.create = function(o) {
    var F = function() {};
    F.prototype = o;
    return new F();
  };
}

CodebenderPlugin.prototype = Object.create(Plugin);

CodebenderPlugin.prototype.getPortsCb = function (cb) {
  var ports = this.element_.getPorts();
  setTimeout(function () {
    cb(ports);
  });
};

CodebenderPlugin.prototype.availablePortsCb = function (cb) {
  var ports = this.element_.availablePorts();
  setTimeout(function () {
    cb(ports);
  });
};

CodebenderPlugin.prototype.getFlashResultCb = function (cb) {
  var result = this.element_.getFlashResult();
  setTimeout(function () {
    cb(result);
  });
};

CodebenderPlugin.prototype.probeUSBCb = function (cb) {
  var result = this.element_.probeUSB();
  setTimeout(function () {
    cb(result);
  });
};

CodebenderPlugin.prototype.initCb = function (cb) {
  this.element_.init();
  setTimeout(function () {
    cb();
  });
};

CodebenderPlugin.prototype.getVersion = function (cb) {
  cb(this.version);
};

module.exports = CodebenderPlugin;

},{}],3:[function(require,module,exports){
// File: /tools/client-util.js

// Log in a list called id
function log(id, msg) {
  var ele = document.getElementById(id);
  if (!ele) {
    var he = document.createElement('h3');
    he.innerHTML = id;
    ele = document.createElement('ul');
    ele.id = id;
    ele.className = "loglist";
    document.body.appendChild(he);
    document.body.appendChild(ele);
  }

  console.log("[" + id + "] " + msg );
  ele.innerHTML += '<li>' + msg + '</li>';
}

function str(obj) {
  return JSON.stringify(obj);
}

try {
  module.exports = {str: str, log: log};
} catch (e) {
  ;
}

window.log = log;
window.str = str;

var dbg = (function () {
  var DEBUG=false;
  if (DEBUG) {
    return function (var_args) {
      console.log.apply(console, ["[Client] "].concat(Array.prototype.slice.call(arguments)));
    };
  } else {
    return function (msg) {};
  }
})();
window.dbg = dbg;

},{}]},{},[1]);

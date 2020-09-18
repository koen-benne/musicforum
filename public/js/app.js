/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener("DOMContentLoaded", function (event) {
  var audioPlayers = document.getElementsByTagName('audioplayer');
  var audioPlayerObjects;

  var _loop = function _loop(_i) {
    var music = audioPlayers[_i].getElementsByClassName('music')[0]; // id for audio element


    var playButton = audioPlayers[_i].getElementsByClassName('play-button')[0]; // play button


    var playhead = audioPlayers[_i].getElementsByClassName('playhead')[0]; // playhead


    var timeline = audioPlayers[_i].getElementsByClassName('timeline')[0]; // timeline
    // timeline width adjusted for playhead


    var timelineWidth = timeline.offsetWidth - playhead.offsetWidth;
    var duration = void 0; // play button event listenter

    playButton.addEventListener("click", play); // timeupdate event listener

    music.addEventListener("timeupdate", timeUpdate, false); // makes timeline clickable

    timeline.addEventListener("click", function (event) {
      moveplayhead(event);
      music.currentTime = duration * clickPercent(event);
    }, false);

    function clickPercent(event) {
      i = _i;
      return (event.clientX - getPosition(timeline)) / timelineWidth;
    } // makes playhead draggable


    playhead.addEventListener('mousedown', mouseDown, false);
    window.addEventListener('mouseup', mouseUp, false); // Boolean value so that audio position is updated only when the playhead is released

    var onplayhead = false; // mouseDown EventListener

    function mouseDown() {
      onplayhead = true;
      window.addEventListener('mousemove', moveplayhead, true);
      music.removeEventListener('timeupdate', timeUpdate, false);
    } // mouseUp EventListener
    // getting input from all mouse clicks


    function mouseUp(event) {
      if (onplayhead === true) {
        moveplayhead(event);
        window.removeEventListener('mousemove', moveplayhead, true); // change current time

        music.currentTime = duration * clickPercent(event);
        music.addEventListener('timeupdate', timeUpdate, false);
      }

      onplayhead = false;
    } // mousemove EventListener
    // Moves playhead as user drags


    function moveplayhead(event) {
      var newMargLeft = event.clientX - getPosition(timeline);

      if (newMargLeft >= 0 && newMargLeft <= timelineWidth) {
        playhead.style.marginLeft = newMargLeft + "px";
      }

      if (newMargLeft < 0) {
        playhead.style.marginLeft = "0px";
      }

      if (newMargLeft > timelineWidth) {
        playhead.style.marginLeft = timelineWidth + "px";
      }
    } // timeUpdate
    // Synchronizes playhead position with current point in audio


    function timeUpdate() {
      var playPercent = timelineWidth * (music.currentTime / duration);
      playhead.style.marginLeft = playPercent + "px";

      if (music.currentTime === duration) {
        playButton.className = "";
        playButton.className = "play-button play";
      }
    } //Play and Pause


    function play() {
      // start music
      if (music.paused) {
        music.play();
        var buttonsToPause = document.getElementsByClassName('pause');

        for (_i = 0; _i < buttonsToPause.length; _i++) {
          var button = buttonsToPause[_i];
          var audioToPause = button.parentElement.parentElement.parentElement.getElementsByClassName('music')[0];
          audioToPause.pause();
          button.className = "";
          button.className = "play-button play";
        } // remove play, add pause


        playButton.className = "";
        playButton.className = "play-button pause";
      } else {
        // pause music
        music.pause(); // remove pause, add play

        playButton.className = "";
        playButton.className = "play-button play";
      }
    } // Gets audio file duration


    music.addEventListener("canplaythrough", function () {
      duration = music.duration;
    }, false); // getPosition
    // Returns elements left position relative to top-left of viewport

    function getPosition(el) {
      i = _i;
      return el.getBoundingClientRect().left;
    }

    i = _i;
  };

  for (var i = 0; i < audioPlayers.length; i++) {
    _loop(i);
  }
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/vagrant/code/musicforum/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/vagrant/code/musicforum/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });
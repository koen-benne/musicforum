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
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./audioplayer */ "./resources/js/audioplayer.js");

__webpack_require__(/*! ./topnav */ "./resources/js/topnav.js");

/***/ }),

/***/ "./resources/js/audioplayer.js":
/*!*************************************!*\
  !*** ./resources/js/audioplayer.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener("DOMContentLoaded", function (event) {
  var
  /**HTMLElement*/
  draggingPlayhead = null;
  document.addEventListener('click', function (e) {
    var target = e.target;
    var classList = target.classList;

    if (classList.contains('play-button')) {
      if (onAudioReady(target)) {
        target.blur();
        playButtonPressed(target);
      }
    } else if (classList.contains('timeline')) {
      if (onAudioReady(target)) {
        movePlayhead(e, true);
      }
    }
  });
  document.addEventListener('mousedown', function (e) {
    var target = e.target;
    var classList = target.classList;

    if (classList.contains('playhead') || draggingPlayhead !== null) {
      dragPlayhead(e);
    }
  });
  document.addEventListener('mouseup', function (e) {
    if (draggingPlayhead !== null) {
      releasePlayhead(e);
    }
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === ' ') {
      var audioPlayer = getPlayingAudio();

      if (audioPlayer) {
        var playButton = audioPlayer.getElementsByClassName('play-button')[0];
        playButtonPressed(playButton);
      }
    }
  });

  function onAudioReady(target) {
    var audioPlayer = target.parentElement.parentElement;
    var
    /**HTMLAudioElement*/
    music = audioPlayer.getElementsByTagName('audio')[0];

    if (music.readyState === 4) {
      return true;
    } else {
      music.addEventListener('canplaythrough', function () {
        playButtonPressed(target);
      });
    }
  }

  function playButtonPressed(button) {
    var audioPlayer = button.parentElement.parentElement;
    var audio = audioPlayer.getElementsByTagName('audio')[0];

    if (button.classList.contains('play')) {
      play(audio, button);
    } else {
      pause(audio, button);
    }
  }

  function play(audio, button) {
    var audioPlayer = button.parentElement.parentElement; // Pause other track if necessary and remove now-playing id

    if (audioPlayer.id !== 'now-playing') {
      var nowPlaying = document.getElementById('now-playing');

      if (nowPlaying) {
        var audioToPause = nowPlaying.getElementsByTagName('audio')[0];
        var buttonToPause = nowPlaying.getElementsByClassName('play-button')[0];
        audioToPause.pause();
        buttonToPause.classList.replace('pause', 'play');
        nowPlaying.id = '';
        audio.removeEventListener('timeupdate', syncPlayheadToAudio);
      }

      audioPlayer.id = 'now-playing';
      audio.addEventListener('timeupdate', syncPlayheadToAudio);
    } // Play song


    audio.play();
    button.classList.replace('play', 'pause');
  }

  function pause(music, button) {
    music.pause();
    button.classList.replace('pause', 'play');
  }

  function movePlayhead(event) {
    var updateAudio = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var target = event.target;
    var audioPlayer;
    var playhead;
    var timeline;

    if (draggingPlayhead) {
      audioPlayer = draggingPlayhead.parentElement.parentElement.parentElement;
      playhead = draggingPlayhead;
      timeline = draggingPlayhead.parentElement;
    } else {
      timeline = target;
      audioPlayer = target.parentElement.parentElement;
      playhead = target.getElementsByClassName('playhead')[0];
    }

    var music = audioPlayer.getElementsByTagName('audio')[0];
    var newMarginLeft = event.clientX - getPosition(timeline);
    var timelineWidth = timeline.offsetWidth - playhead.offsetWidth;

    if (newMarginLeft >= 0 && newMarginLeft <= timelineWidth) {
      playhead.style.marginLeft = newMarginLeft + "px";
    }

    if (newMarginLeft < 0) {
      playhead.style.marginLeft = "0px";
    }

    if (newMarginLeft > timelineWidth) {
      playhead.style.marginLeft = timelineWidth + "px";
    }

    music.currentTime = music.duration * clickPercent(event, timeline, timelineWidth);
  }

  function changeTime(music, sec) {
    music.currentTime += sec;
    syncPlayheadToAudio();
  }

  function dragPlayhead(event) {
    document.body.classList.add('no-select');
    draggingPlayhead = event.target;
    var audioPlayer = draggingPlayhead.parentElement.parentElement.parentElement;
    var audio = audioPlayer.getElementsByTagName('audio')[0];
    window.addEventListener('mousemove', movePlayhead, true);

    if (audioPlayer.id === 'now-playing') {
      audio.removeEventListener('timeupdate', syncPlayheadToAudio, false);
    }
  }

  function releasePlayhead(event) {
    window.removeEventListener('mousemove', movePlayhead, true);
    var audioPlayer = draggingPlayhead.parentElement.parentElement.parentElement;
    var audio = audioPlayer.getElementsByTagName('audio')[0];
    var timeline = draggingPlayhead.parentElement;
    var timelineWidth = timeline.offsetWidth - draggingPlayhead.offsetWidth; // change current time

    audio.currentTime = audio.duration * clickPercent(event, timeline, timelineWidth);

    if (audioPlayer.id === 'now-playing') {
      audio.addEventListener('timeupdate', syncPlayheadToAudio, false);
    }

    document.body.classList.remove('no-select');
    draggingPlayhead = null;
  } // Synchronizes playhead position with current point in audio


  function syncPlayheadToAudio() {
    var audioPlayer = getPlayingAudio();
    var timeline = audioPlayer.getElementsByClassName('timeline')[0];
    var playhead = timeline.getElementsByClassName('playhead')[0];
    var playButton = audioPlayer.getElementsByClassName('play-button')[0];
    var audio = audioPlayer.getElementsByTagName('audio')[0];
    var timelineWidth = timeline.offsetWidth - playhead.offsetWidth;
    var duration = audio.duration;
    var playPercent = timelineWidth * (audio.currentTime / duration);
    playhead.style.marginLeft = playPercent + "px";

    if (audio.currentTime === duration) {
      playButton.classList.replace('pause', 'play');
    }
  }

  function getPosition(el) {
    return el.getBoundingClientRect().left;
  }

  function clickPercent(event, timeline, timelineWidth) {
    return (event.clientX - getPosition(timeline)) / timelineWidth;
  }

  function getPlayingAudio() {
    return document.getElementById('now-playing');
  }
});

/***/ }),

/***/ "./resources/js/topnav.js":
/*!********************************!*\
  !*** ./resources/js/topnav.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var topnav = document.getElementById('topnav');
document.addEventListener('click', function (e) {
  var target = e.target;

  if (target.id === 'logout-button') {
    e.preventDefault();
    document.getElementById('frm-logout').submit();
  }

  var menus = document.getElementsByClassName('dropdown-menu');

  if (target.classList.contains('dropdown-button')) {
    for (var i = 0; i < menus.length; i++) {
      var classList = menus[i].classList;

      if (classList.contains('invisible')) {
        classList.remove('invisible');
      } else {
        classList.add('invisible');
      }
    }
  } else if (!target.classList.contains('dropdown-item')) {
    for (var _i = 0; _i < menus.length; _i++) {
      var _classList = menus[_i].classList;

      if (!_classList.contains('invisible')) {
        _classList.add('invisible');
      }
    }
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
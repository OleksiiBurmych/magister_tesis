/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/shortcode/blockIcon.js":
/*!************************************!*\
  !*** ./src/shortcode/blockIcon.js ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const icons = {};
icons.teamFree = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
  src: TeamFreeGbScript.path + 'src/Admin/GutenbergBlock/src/wp-team-block.svg'
});
/* harmony default export */ __webpack_exports__["default"] = (icons);

/***/ }),

/***/ "./src/shortcode/dynamicShortcode.js":
/*!*******************************************!*\
  !*** ./src/shortcode/dynamicShortcode.js ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);


/**
 * Shortcode select component.
 */
const {
  __
} = wp.i18n;
const {
  Fragment
} = wp.element;

const DynamicShortcodeInput = _ref => {
  let {
    attributes: {
      shortcode,
      shortcodelist
    },
    shortcodeUpdate
  } = _ref;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "sptf_block_shortcode"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "sptf_block_shortcode_title"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: TeamFreeGbScript.path + 'src/Admin/GutenbergBlock/src/wp-team-block.svg'
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h4", null, __('WP Team', 'wp-team'))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    className: "sptf_block_shortcode_text"
  }, __('Select a Team')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("select", {
    className: "sptf-shortcode-selector",
    onChange: e => shortcodeUpdate(e),
    value: shortcode
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
    value: "0"
  }, __('-- Select a Team --', 'wp-team')), shortcodelist.map(value => {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
      value: `${value.id}`,
      key: value.id
    }, `${value.title} (#${value.id})`);
  }))));
};

/* harmony default export */ __webpack_exports__["default"] = (DynamicShortcodeInput);

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _shortcode_blockIcon__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./shortcode/blockIcon */ "./src/shortcode/blockIcon.js");
/* harmony import */ var _shortcode_dynamicShortcode__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./shortcode/dynamicShortcode */ "./src/shortcode/dynamicShortcode.js");



const {
  __
} = wp.i18n;
const {
  registerBlockType
} = wp.blocks;
const {
  Fragment
} = wp.element;
const ServerSideRender = wp.serverSideRender;
/**
 * Register: aa Gutenberg Block.
 */

registerBlockType('team-free/shortcode', {
  title: __('WP Team', 'wp-team'),
  description: __('Use WP Team to insert a team in your page', 'wp-team'),
  icon: _shortcode_blockIcon__WEBPACK_IMPORTED_MODULE_1__["default"].teamFree,
  category: 'common',
  supports: {
    html: false
  },
  edit: props => {
    const {
      attributes,
      setAttributes
    } = props;

    let scriptLoad = shortcodeId => {
      let spspBlockLoaded = false;
      let spspBlockLoadedInterval = setInterval(function () {
        let uniqId = jQuery("#sptp-" + shortcodeId).parents().attr('id');

        if (document.getElementById(uniqId)) {
          //Actual functions goes here
          jQuery.getScript(TeamFreeGbScript.loodScript);
          spspBlockLoaded = true;
          uniqId = '';
        }

        if (spspBlockLoaded) {
          clearInterval(spspBlockLoadedInterval);
        }

        if (0 == shortcodeId) {
          clearInterval(spspBlockLoadedInterval);
        }
      }, 100);
    };

    let updateShortcode = updateShortcode => {
      setAttributes({
        shortcode: updateShortcode.target.value
      });
    };

    let shortcodeUpdate = e => {
      updateShortcode(e);
      let shortcodeId = e.target.value;
      scriptLoad(shortcodeId);
    };

    document.addEventListener('readystatechange', event => {
      if (event.target.readyState === "complete") {
        let shortcodeId = attributes.shortcode;
        scriptLoad(shortcodeId);
      }
    });

    if (attributes.shortcodelist.length === 0) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "sptf_block_shortcode"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "sptf_block_shortcode_title"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
        src: TeamFreeGbScript.path + 'src/Admin/GutenbergBlock/src/wp-team-block.svg'
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h4", null, __('WP Team', 'wp-team'))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
        className: "sptf_block_shortcode_text"
      }, "No team found. ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
        href: TeamFreeGbScript.url
      }, "Create a team now!"))));
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_shortcode_dynamicShortcode__WEBPACK_IMPORTED_MODULE_2__["default"], {
      attributes: attributes,
      shortcodeUpdate: shortcodeUpdate
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ServerSideRender, {
      block: "team-free/shortcode",
      attributes: attributes
    }));
  },

  save() {
    // Rendering in PHP
    return null;
  }

});
}();
/******/ })()
;
//# sourceMappingURL=index.js.map
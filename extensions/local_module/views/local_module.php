<style type="text/css">
html {
  line-height: 1.15;
  /* 1 */
  -ms-text-size-adjust: 100%;
  /* 2 */
  -webkit-text-size-adjust: 100%;
  /* 2 */
}

/* Sections
   ========================================================================== */
/**
 * Remove the margin in all browsers (opinionated).
 */
body {
  margin: 0;
}

/**
 * Add the correct display in IE 9-.
 */
article,
aside,
footer,
header,
nav,
section {
  display: block;
}

/**
 * Correct the font size and margin on `h1` elements within `section` and
 * `article` contexts in Chrome, Firefox, and Safari.
 */
h1 {
  font-size: 2em;
  margin: 0.67em 0;
}

/* Grouping content
   ========================================================================== */
/**
 * Add the correct display in IE 9-.
 * 1. Add the correct display in IE.
 */
figcaption,
figure,
main {
  /* 1 */
  display: block;
}

/**
 * Add the correct margin in IE 8.
 */
figure {
  margin: 1em 40px;
}

/**
 * 1. Add the correct box sizing in Firefox.
 * 2. Show the overflow in Edge and IE.
 */
hr {
  box-sizing: content-box;
  /* 1 */
  height: 0;
  /* 1 */
  overflow: visible;
  /* 2 */
}

/**
 * 1. Correct the inheritance and scaling of font size in all browsers.
 * 2. Correct the odd `em` font sizing in all browsers.
 */
pre {
  font-family: monospace, monospace;
  /* 1 */
  font-size: 1em;
  /* 2 */
}

/* Text-level semantics
   ========================================================================== */
/**
 * 1. Remove the gray background on active links in IE 10.
 * 2. Remove gaps in links underline in iOS 8+ and Safari 8+.
 */
a {
  background-color: transparent;
  /* 1 */
  -webkit-text-decoration-skip: objects;
  /* 2 */
}

/**
 * 1. Remove the bottom border in Chrome 57- and Firefox 39-.
 * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
 */
abbr[title] {
  border-bottom: none;
  /* 1 */
  text-decoration: underline;
  /* 2 */
  text-decoration: underline dotted;
  /* 2 */
}

/**
 * Prevent the duplicate application of `bolder` by the next rule in Safari 6.
 */
b,
strong {
  font-weight: inherit;
}

/**
 * Add the correct font weight in Chrome, Edge, and Safari.
 */
b,
strong {
  font-weight: bolder;
}

/**
 * 1. Correct the inheritance and scaling of font size in all browsers.
 * 2. Correct the odd `em` font sizing in all browsers.
 */
code,
kbd,
samp {
  font-family: monospace, monospace;
  /* 1 */
  font-size: 1em;
  /* 2 */
}

/**
 * Add the correct font style in Android 4.3-.
 */
dfn {
  font-style: italic;
}

/**
 * Add the correct background and color in IE 9-.
 */
mark {
  background-color: #ff0;
  color: #000;
}

/**
 * Add the correct font size in all browsers.
 */
small {
  font-size: 80%;
}

/**
 * Prevent `sub` and `sup` elements from affecting the line height in
 * all browsers.
 */
sub,
sup {
  font-size: 75%;
  line-height: 0;
  position: relative;
  vertical-align: baseline;
}

sub {
  bottom: -0.25em;
}

sup {
  top: -0.5em;
}

/* Embedded content
   ========================================================================== */
/**
 * Add the correct display in IE 9-.
 */
audio,
video {
  display: inline-block;
}

/**
 * Add the correct display in iOS 4-7.
 */
audio:not([controls]) {
  display: none;
  height: 0;
}

/**
 * Remove the border on images inside links in IE 10-.
 */
img {
  border-style: none;
}

/**
 * Hide the overflow in IE.
 */
svg:not(:root) {
  overflow: hidden;
}

/* Forms
   ========================================================================== */
/**
 * 1. Change the font styles in all browsers (opinionated).
 * 2. Remove the margin in Firefox and Safari.
 */
button,
input,
optgroup,
select,
textarea {
  font-family: sans-serif;
  /* 1 */
  font-size: 100%;
  /* 1 */
  line-height: 1.15;
  /* 1 */
  margin: 0;
  /* 2 */
}

/**
 * Show the overflow in IE.
 * 1. Show the overflow in Edge.
 */
button,
input {
  /* 1 */
  overflow: visible;
}

/**
 * Remove the inheritance of text transform in Edge, Firefox, and IE.
 * 1. Remove the inheritance of text transform in Firefox.
 */
button,
select {
  /* 1 */
  text-transform: none;
}

/**
 * 1. Prevent a WebKit bug where (2) destroys native `audio` and `video`
 *    controls in Android 4.
 * 2. Correct the inability to style clickable types in iOS and Safari.
 */
button,
html [type="button"],
[type="reset"],
[type="submit"] {
  -webkit-appearance: button;
  /* 2 */
}

/**
 * Remove the inner border and padding in Firefox.
 */
button::-moz-focus-inner,
[type="button"]::-moz-focus-inner,
[type="reset"]::-moz-focus-inner,
[type="submit"]::-moz-focus-inner {
  border-style: none;
  padding: 0;
}

/**
 * Restore the focus styles unset by the previous rule.
 */
button:-moz-focusring,
[type="button"]:-moz-focusring,
[type="reset"]:-moz-focusring,
[type="submit"]:-moz-focusring {
  outline: 1px dotted ButtonText;
}

/**
 * Correct the padding in Firefox.
 */
fieldset {
  padding: 0.35em 0.75em 0.625em;
}

/**
 * 1. Correct the text wrapping in Edge and IE.
 * 2. Correct the color inheritance from `fieldset` elements in IE.
 * 3. Remove the padding so developers are not caught out when they zero out
 *    `fieldset` elements in all browsers.
 */
legend {
  box-sizing: border-box;
  /* 1 */
  color: inherit;
  /* 2 */
  display: table;
  /* 1 */
  max-width: 100%;
  /* 1 */
  padding: 0;
  /* 3 */
  white-space: normal;
  /* 1 */
}

/**
 * 1. Add the correct display in IE 9-.
 * 2. Add the correct vertical alignment in Chrome, Firefox, and Opera.
 */
progress {
  display: inline-block;
  /* 1 */
  vertical-align: baseline;
  /* 2 */
}

/**
 * Remove the default vertical scrollbar in IE.
 */
textarea {
  overflow: auto;
}

/**
 * 1. Add the correct box sizing in IE 10-.
 * 2. Remove the padding in IE 10-.
 */
[type="checkbox"],
[type="radio"] {
  box-sizing: border-box;
  /* 1 */
  padding: 0;
  /* 2 */
}

/**
 * Correct the cursor style of increment and decrement buttons in Chrome.
 */
[type="number"]::-webkit-inner-spin-button,
[type="number"]::-webkit-outer-spin-button {
  height: auto;
}

/**
 * 1. Correct the odd appearance in Chrome and Safari.
 * 2. Correct the outline style in Safari.
 */
[type="search"] {
  -webkit-appearance: textfield;
  /* 1 */
  outline-offset: -2px;
  /* 2 */
}

/**
 * Remove the inner padding and cancel buttons in Chrome and Safari on macOS.
 */
[type="search"]::-webkit-search-cancel-button,
[type="search"]::-webkit-search-decoration {
  -webkit-appearance: none;
}

/**
 * 1. Correct the inability to style clickable types in iOS and Safari.
 * 2. Change font properties to `inherit` in Safari.
 */
::-webkit-file-upload-button {
  -webkit-appearance: button;
  /* 1 */
  font: inherit;
  /* 2 */
}

/* Interactive
   ========================================================================== */
/*
 * Add the correct display in IE 9-.
 * 1. Add the correct display in Edge, IE, and Firefox.
 */
details,
menu {
  display: block;
}

/*
 * Add the correct display in all browsers.
 */
summary {
  display: list-item;
}

/* Scripting
   ========================================================================== */
/**
 * Add the correct display in IE 9-.
 */
canvas {
  display: inline-block;
}

/**
 * Add the correct display in IE.
 */
template {
  display: none;
}

/* Hidden
   ========================================================================== */
/**
 * Add the correct display in IE 10-.
 */
[hidden] {
  display: none;
}

html {
  height: 100%;
}

fieldset {
  margin: 0;
  padding: 0;
  -webkit-margin-start: 0;
  -webkit-margin-end: 0;
  -webkit-padding-before: 0;
  -webkit-padding-start: 0;
  -webkit-padding-end: 0;
  -webkit-padding-after: 0;
  border: 0;
}

legend {
  margin: 0;
  padding: 0;
  display: block;
  -webkit-padding-start: 0;
  -webkit-padding-end: 0;
}

/*===============================
=            Choices            =
===============================*/
.choices {
  position: relative;
  margin-bottom: 24px;
  font-size: 16px;
}

.choices:focus {
  outline: none;
}

.choices:last-child {
  margin-bottom: 0;
}

.choices.is-disabled .choices__inner, .choices.is-disabled .choices__input {
  background-color: #EAEAEA;
  cursor: not-allowed;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.choices.is-disabled .choices__item {
  cursor: not-allowed;
}

.choices[data-type*="select-one"] {
  cursor: pointer;
}

.choices[data-type*="select-one"] .choices__inner {
  padding-bottom: 7.5px;
}

.choices[data-type*="select-one"] .choices__input {
  display: block;
  width: 100%;
  padding: 10px;
  border-bottom: 1px solid #DDDDDD;
  background-color: #FFFFFF;
  margin: 0;
}

.choices[data-type*="select-one"] .choices__button {
  background-image: url("../../icons/cross-inverse.svg");
  padding: 0;
  background-size: 8px;
  height: 100%;
  position: absolute;
  top: 50%;
  right: 0;
  margin-top: -10px;
  margin-right: 25px;
  height: 20px;
  width: 20px;
  border-radius: 10em;
  opacity: .5;
}

.choices[data-type*="select-one"] .choices__button:hover, .choices[data-type*="select-one"] .choices__button:focus {
  opacity: 1;
}

.choices[data-type*="select-one"] .choices__button:focus {
  box-shadow: 0px 0px 0px 2px #00BCD4;
}

.choices[data-type*="select-one"]:after {
  content: "";
  height: 0;
  width: 0;
  border-style: solid;
  border-color: #333333 transparent transparent transparent;
  border-width: 5px;
  position: absolute;
  right: 11.5px;
  top: 50%;
  margin-top: -2.5px;
  pointer-events: none;
}

.choices[data-type*="select-one"].is-open:after {
  border-color: transparent transparent #333333 transparent;
  margin-top: -7.5px;
}

.choices[data-type*="select-one"][dir="rtl"]:after {
  left: 11.5px;
  right: auto;
}

.choices[data-type*="select-one"][dir="rtl"] .choices__button {
  right: auto;
  left: 0;
  margin-left: 25px;
  margin-right: 0;
}

.choices[data-type*="select-multiple"] .choices__inner, .choices[data-type*="text"] .choices__inner {
  cursor: text;
}

.choices[data-type*="select-multiple"] .choices__button, .choices[data-type*="text"] .choices__button {
  position: relative;
  display: inline-block;
  margin-top: 0;
  margin-right: -4px;
  margin-bottom: 0;
  margin-left: 8px;
  padding-left: 16px;
  border-left: 1px solid #008fa1;
  background-image: url("../../icons/cross.svg");
  background-size: 8px;
  width: 8px;
  line-height: 1;
  opacity: .75;
}

.choices[data-type*="select-multiple"] .choices__button:hover, .choices[data-type*="select-multiple"] .choices__button:focus, .choices[data-type*="text"] .choices__button:hover, .choices[data-type*="text"] .choices__button:focus {
  opacity: 1;
}

.choices__inner {
  display: inline-block;
  vertical-align: top;
  width: 100%;
  background-color: #f9f9f9;
  padding: 7.5px 7.5px 3.75px;
  border: 1px solid #DDDDDD;
  border-radius: 2.5px;
  font-size: 14px;
  min-height: 44px;
  overflow: hidden;
}

.is-focused .choices__inner, .is-open .choices__inner {
  border-color: #b7b7b7;
}

.is-open .choices__inner {
  border-radius: 2.5px 2.5px 0 0;
}

.is-flipped.is-open .choices__inner {
  border-radius: 0 0 2.5px 2.5px;
}

.choices__list {
  margin: 0;
  padding-left: 0;
  list-style: none;
}

.choices__list--single {
  display: inline-block;
  padding: 4px 16px 4px 4px;
  width: 100%;
}

[dir="rtl"] .choices__list--single {
  padding-right: 4px;
  padding-left: 16px;
}

.choices__list--single .choices__item {
  width: 100%;
}

.choices__list--multiple {
  display: inline;
}

.choices__list--multiple .choices__item {
  display: inline-block;
  vertical-align: middle;
  border-radius: 20px;
  padding: 4px 10px;
  font-size: 12px;
  font-weight: 500;
  margin-right: 3.75px;
  margin-bottom: 3.75px;
  background-color: #00BCD4;
  border: 1px solid #00a5bb;
  color: #FFFFFF;
  word-break: break-all;
}

.choices__list--multiple .choices__item[data-deletable] {
  padding-right: 5px;
}

[dir="rtl"] .choices__list--multiple .choices__item {
  margin-right: 0;
  margin-left: 3.75px;
}

.choices__list--multiple .choices__item.is-highlighted {
  background-color: #00a5bb;
  border: 1px solid #008fa1;
}

.is-disabled .choices__list--multiple .choices__item {
  background-color: #aaaaaa;
  border: 1px solid #919191;
}

.choices__list--dropdown {
  display: none;
  z-index: 1;
  position: absolute;
  width: 100%;
  background-color: #FFFFFF;
  border: 1px solid #DDDDDD;
  top: 100%;
  margin-top: -1px;
  border-bottom-left-radius: 2.5px;
  border-bottom-right-radius: 2.5px;
  overflow: hidden;
  word-break: break-all;
}

.choices__list--dropdown.is-active {
  display: block;
}

.is-open .choices__list--dropdown {
  border-color: #b7b7b7;
}

.is-flipped .choices__list--dropdown {
  top: auto;
  bottom: 100%;
  margin-top: 0;
  margin-bottom: -1px;
  border-radius: .25rem .25rem 0 0;
}

.choices__list--dropdown .choices__list {
  position: relative;
  max-height: 300px;
  overflow: auto;
  -webkit-overflow-scrolling: touch;
  will-change: scroll-position;
}

.choices__list--dropdown .choices__item {
  position: relative;
  padding: 10px;
  font-size: 14px;
}

[dir="rtl"] .choices__list--dropdown .choices__item {
  text-align: right;
}

@media (min-width: 640px) {
  .choices__list--dropdown .choices__item--selectable {
    padding-right: 100px;
  }
  .choices__list--dropdown .choices__item--selectable:after {
    content: attr(data-select-text);
    font-size: 12px;
    opacity: 0;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
  }
  [dir="rtl"] .choices__list--dropdown .choices__item--selectable {
    text-align: right;
    padding-left: 100px;
    padding-right: 10px;
  }
  [dir="rtl"] .choices__list--dropdown .choices__item--selectable:after {
    right: auto;
    left: 10px;
  }
}

.choices__list--dropdown .choices__item--selectable.is-highlighted {
  background-color: #f2f2f2;
}

.choices__list--dropdown .choices__item--selectable.is-highlighted:after {
  opacity: .5;
}

.choices__item {
  cursor: default;
}

.choices__item--selectable {
  cursor: pointer;
}

.choices__item--disabled {
  cursor: not-allowed;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  opacity: .5;
}

.choices__heading {
  font-weight: 600;
  font-size: 12px;
  padding: 10px;
  border-bottom: 1px solid #f7f7f7;
  color: gray;
}

.choices__button {
  text-indent: -9999px;
  -webkit-appearance: none;
  -moz-appearance: none;
       appearance: none;
  border: 0;
  background-color: transparent;
  background-repeat: no-repeat;
  background-position: center;
  cursor: pointer;
}

.choices__button:focus {
  outline: none;
}

.choices__input {
  display: inline-block;
  vertical-align: baseline;
  background-color: #f9f9f9;
  font-size: 14px;
  margin-bottom: 5px;
  border: 0;
  border-radius: 0;
  max-width: 100%;
  padding: 4px 0 4px 2px;
}

.choices__input:focus {
  outline: 0;
}

[dir="rtl"] .choices__input {
  padding-right: 2px;
  padding-left: 0;
}

.choices__placeholder {
  opacity: .5;
}

/*=====  End of Choices  ======*/
* {
  box-sizing: border-box;
}

[type="checkbox"]:checked,
[type="checkbox"]:not(:checked) {
  position: absolute;
  left: -9999px;
  visibility: hidden;
  transform: scale(0);
  opacity: 0;
}

[type="checkbox"]:checked + label,
[type="checkbox"]:not(:checked) + label {
  position: relative;
  padding-left: 33px;
  cursor: pointer;
}

[type="checkbox"]:checked + label:before,
[type="checkbox"]:not(:checked) + label:before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 20px;
  height: 20px;
  border-radius: 3px;
  background: #fff;
}

[type="checkbox"]:checked + label:after,
[type="checkbox"]:not(:checked) + label:after {
  content: '';
  width: 12px;
  height: 12px;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%2300ad5f' aria-hidden='true' data-prefix='fas' data-icon='check' class='svg-inline--fa fa-check fa-w-16' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3e%3cpath fill='%2300ad5f' d='M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z'%3e%3c/path%3e%3c/svg%3e");
  position: absolute;
  top: 4px;
  left: 4px;
  border-radius: 100%;
  transition: all 0.2s ease;
}

[type="checkbox"]:not(:checked) + label:after {
  opacity: 0;
  transform: scale(0);
}

[type="checkbox"]:checked + label:after {
  opacity: 1;
  transform: scale(1);
}

.s013 {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-pack: center;
      justify-content: center;
  -ms-flex-align: center;
      align-items: center;
  /*background: url("images/Searchs_013.png");*/
  background-size: cover;
  background-position: center center;
  padding: 15px;
  font-family: 'Poppins', sans-serif;
}

.s013 form {
  width: 100%;
  /*max-width: 914px;*/
  margin: 0;
}

.s013 form fieldset {
  margin-bottom: 50px;
}

.s013 form fieldset legend {
  font-size: 36px;
  font-weight: bold;
  color: #fff;
  font-family: 'Poppins', sans-serif;
  text-align: center;
}

.s013 form .inner-form {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-pack: justify;
      justify-content: space-between;
}

.s013 form .inner-form .left {
  -ms-flex-positive: 1;
      flex-grow: 1;
  display: -ms-flexbox;
  display: flex;
}

.s013 form .inner-form .input-wrap {
  background: #fff;
  height: 50px;
  position: relative;
  padding: 10px 15px 10px 15px;
}

.s013 form .inner-form .input-wrap .input-field label {
  font-size: 11px;
  font-weight: 500;
  display: block;
  color: #555;
}

.s013 form .inner-form .input-wrap .input-field input {
  font-size: 16px;
  color: #0000008a;
  background: transparent;
  width: 100%;
  border: 0;
  font-family: 'Lato', sans-serif;
  padding: 8px 0;
}

.s013 form .inner-form .input-wrap .input-field input.placeholder {
  color: #808080;
}

.s013 form .inner-form .input-wrap .input-field input:-moz-placeholder {
  color: #808080;
}

.s013 form .inner-form .input-wrap .input-field input::-webkit-input-placeholder {
  color: #808080;
}

.s013 form .inner-form .input-wrap .input-field input.hover, .s013 form .inner-form .input-wrap .input-field input:focus {
  box-shadow: none;
  outline: 0;
}

.s013 form .inner-form .input-wrap.first {
  -ms-flex-positive: 1;
      flex-grow: 1;
  border-radius: 3px 0 0 3px;
}

.s013 form .inner-form .input-wrap.second {
  min-width: 262px;
  border-radius: 0 3px 3px 0;
  border-left: 1px solid #e5e5e5;
}

.s013 form .input-select {
  height: 34px;
  padding: 10px 0 6px 0;
}

.s013 form .choices__inner {
  background: transparent;
  border-radius: 0;
  border: 0;
  height: 100%;
  color: #333;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
      align-items: center;
  padding: 0;
  padding-right: 30px;
  font-size: 16px;
  min-height: auto;
  font-family: 'Lato', sans-serif;
}

.s013 form .choices__inner .choices__list.choices__list--single {
  display: -ms-flexbox;
  display: flex;
  padding: 0;
  -ms-flex-align: center;
      align-items: center;
  height: 100%;
}

.s013 form .choices__inner .choices__item.choices__item--selectable.choices__placeholder {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
      align-items: center;
  height: 100%;
  opacity: 1;
  color: #808080;
  font-weight: 400;
}

.s013 form .choices__inner .choices__list--single .choices__item {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
      align-items: center;
  height: 100%;
}

.s013 form .choices__list.choices__list--dropdown {
  border: 0;
  background: #fff;
  padding: 10px 15px;
  margin-top: 10px;
  border-radius: 3px;
  box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
}

.s013 form .choices__list.choices__list--dropdown .choices__item--selectable {
  padding-right: 0;
}

.s013 form .choices__list--dropdown .choices__item--selectable.is-highlighted {
  background: transparent;
  color: #333;
}

.s013 form .choices__list--dropdown .choices__item {
  color: #555;
  min-height: 24px;
}

.s013 form .choices[data-type*="select-one"] .choices__inner {
  padding-bottom: 0;
}

.s013 form .choices[data-type*="select-one"]:after {
  border: 0;
  width: 18px;
  height: 18px;
  margin: 0;
  transform: none;
  opacity: 1;
  right: 0;
  top: 0;
  background-size: 18px 18px;
  background-position: right center;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%23999' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3e%3cpath d='M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z'/%3e%3c/svg%3e");
  background-repeat: no-repeat;
}

.s013 form .choices[data-type*="select-one"].is-open:after {
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%23999' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3e%3cpath d='M12 8l-6 6 1.41 1.41L12 10.83l4.59 4.58L18 14z'/%3e%3c/svg%3e");
}

.s013 form .btn-search {
  min-width: 110px;
  height: 50px;
  padding: 0 15px;
  background: #f5511e;
  white-space: nowrap;
  border-radius: 3px;
  font-size: 16px;
  color: #fff;
  transition: all .2s ease-out, color .2s ease-out;
  border: 0;
  cursor: pointer;
  font-weight: 400;
  font-family: 'Poppins', sans-serif;
  margin-left: 10px;
}

.s013 form .btn-search:hover {
  background: #f5511e;
}

@media screen and (max-width: 767px) {
  .s013 form .inner-form {
    display: block;
  }
  .s013 form .inner-form .left {
    display: block;
  }
  .s013 form .inner-form .left .input-wrap {
    margin-bottom: 15px;
  }
  .s013 form .btn-search {
    margin: 0;
    width: 100%;
  }
}

/*# sourceMappingURL=Searchs_013.css.map */

</style>
			<?php if ($location_search === TRUE) { ?>
				
					<div class="fh5co-cover ">
                    <div class="desc">
                        <div class="row">
                           <!-- <div class="desc2 mrg_left_hd col-sm-6 col-md-6 padd-none">
                                    <h2><?php echo lang('book_hotel_or_order_food_from_favourite_restaurants');  ?></h2>
                                    <h3><?php echo lang('explore_unique_and_best_deals');  ?></h3>
                                   
                            </div>-->
                             <div class="col-xs-12 col-sm-1 col-md-1 padd-none">
                             </div> 
                           
                            <div class="col-xs-12 col-sm-10 col-md-10 center-block">
						
							
							<span class="search-label sr-only"><?php echo lang('label_search_query'); ?></span>
							
								<?php if ($location_search_mode === 'multi') { ?>
								<div class="s013">
									<form id="location-form" method="POST" action="<?php echo $local_action; ?>" class="form-inline" role="form">
                  
                                	<fieldset>
							          <legend>Moving things forward</legend>
							        </fieldset>
							        <div class="inner-form">
							          <div class="left">
							            <div class="input-wrap first" style="margin-right: 10px;">
							              <div class="input-field first">
							                <input type="text" id="search_query" name="search_query" placeholder="<?php echo lang('label_search_query'); ?>" value="" />
							              </div><br />
                            <span id="ent_loc" class="search_err"><?php echo lang('err_label_search_query'); ?></span>
							            </div>
							            <div class="input-wrap second padd-none">
							              
							               
							                  <select data-trigger="" class="cs-select cs-skin-border1 class-select1" aria-invalid="false" name="location_type">
                                  <option value="both" selected>
                                <?php echo lang('both');?>
                              </option>
                              <option value="restaurant">
                                <?php echo lang('restaurants');?>
                              </option>
                              <option value="cafe">
                                <?php echo lang('cafeteria');?>
                              </option>
                              
                          </select>
							               
							            </div>
							          </div>
                         <button type="button" id="search" class="btn-search" onclick="searchLocal()"><?php echo lang('search_restaurants'); ?></button>
							         
							      	</form>
							      	</div>
								<?php } else { ?>
									<a class="btn btn-block btn-primary" href="<?php echo $single_location_url; ?>"><?php echo lang('text_find'); ?></a>
								<?php } ?>
							</div>
					
                        </div>
                    </div>
                </div>
				
			<?php } ?>

			<?php if ($location_search !== TRUE AND $rsegment !== 'locations') { ?>
				<div id="local-info" class=" col-xs-12 col-sm-12 col-md-12 padd-none" style="display: <?php echo ($local_info) ? 'block' : 'none'; ?>">
					<div class="display-local" >
						<?php if ($location_search_mode === 'multi') { ?>
							<div class="">
								<div class="row local-search bg-warning"  style="display: none;">
									<a class="close-search clickable" onclick="toggleLocalSearch();">&times;</a>
									<div class=" col-xs-12 col-sm-12 col-md-12 center-block">
										<div class="postcode-group text-center">
											<?php echo lang('text_no_search_query'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
											<div class="input-group">
												<input type="text" id="search-query" class="form-control text-center postcode-control input-xs" name="search_query" placeholder="<?php echo lang('label_search_query'); ?>" value="<?php echo $search_query; ?>">
												<a id="search" class="input-group-addon btn btn-primary" onclick="searchLocal();"><?php echo lang('button_search_location'); ?></a>
											</div>
										</div>
									</div>
								</div>

								<div class="row local-change" style="display: <?php echo (!empty($search_query) OR (empty($search_query) AND $location_order !== '1')) ? 'block' : 'none'; ?>">
									<div class="col-xs-12 col-sm-7">
										<?php $text_location_summary = ($has_search_query AND $delivery_coverage) ? lang('text_location_summary') : lang('text_delivery_coverage'); ?>
										<?php $text_search_query = (empty($search_query)) ? lang('text_enter_location') : sprintf($text_location_summary, lang('text_at').$search_query); ?>
										<?php echo $text_search_query; ?>&nbsp;&nbsp;
										<a onclick="toggleLocalSearch();" class="clickable btn-link visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="">
											<?php echo empty($search_query) ? lang('button_enter_location') : lang('button_change_location'); ?>
										</a>
									</div>

									<?php if (!in_array($rsegment, array('local', 'locations'))) { ?>
										<div class="col-xs-12 col-sm-5 text-right">
											<a class="btn btn-primary btn-menus" href="<?php echo site_url('local?location_id='.$location_id).'#local-menus'; ?>"><i class="fa fa-cutlery"></i>
												<span>&nbsp;&nbsp;<?php echo lang('text_goto_menus'); ?></span>
											</a>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>

						<div class="">
							<div class="row boxes">

								<div class="col-sm-7 col-md-7 col-xs-7">
							<span class="padd-left return"><a href="#">< Return to search results</a></span>
							<h1 class="list-title padd-left"><?php echo $location_name; ?></h1> 
							<div class="location padd-left col-sm-12 col-md-12 col-xs-12">
								<div class="col-sm-1 col-md-1 col-xs-1">
									<i class="fa fa-map-marker" style="color:#f5511e"></i>
								</div>
								<div class="col-sm-11 col-md-11 col-xs-10">
									<span class="full_location">
										<b>Address: </b>	<br>								
										<?php echo str_replace('<br />', ', ', $location_address); ?>
									</span>
								</div>
								<div class="col-sm-1 col-md-1 col-xs-1">
									<i class="fa fa-phone" style="color:#f5511e"></i>
								</div>
								<div class="col-sm-11 col-md-11 col-xs-10">
									<span class="full_location">
									<b>Contact: </b> 
										+ <?php echo $location_email; ?>
									</span>
								</div>
								<div class="col-sm-1 col-md-1 col-xs-1">
									<i class="fa fa-envelope" style="color:#f5511e"></i>
								</div>
								<div class="col-sm-11 col-md-11 col-xs-10">
									<span class="full_location">
										<b>E-mail: </b> 									
										<a href="#"><?php echo $location_email; ?></a>
									</span>
								</div>
							</div>
						</div>
						<div class="col-sm-5 col-md-5 col-xs-5 ">
							<div class="col-sm-12 col-md-12 col-xs-12 ">
								<div class="col-sm-8 col-md-8 col-xs-8 padd-none">
								<!-- <p class="book"><?php echo lang('book_a_table_from'); ?> SAR 10</p> -->
								</div>
								<div class="col-sm-4 col-md-4 col-xs-4 padd-none">
								<span class="ratings1">
								<span class="star_rate">
								<?php if (config_item('allow_reviews') !== '1') { ?>
											<dd class="text-muted">
												<div class="rating rating-sm">
													<span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star-half-o"></span><span class="fa fa-star-o"></span>
													<span class="small"><?php echo $text_total_review; ?></span>
												</div>
											</dd>
										<?php } ?>
									<!--<a href="#"><span class="fa fa-star"></span> 4.0</a></span>-->
								</span>
								</div>
					        </div>
					        <div class="col-sm-12 col-md-12 col-xs-12">
					            <div class="map">
					            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d233328.2106301447!2d45.0105926060563!3d23.876941037343624!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2sSaudi+Arabia!5e0!3m2!1sen!2sin!4v1538024819742" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
					            </div>
							</div>
						</div>


								<div class="col-xs-12 col-sm-5 col-md-5" style="display: none;">
									<?php /*if (!empty($location_image)) { ?>
										<img class="img-responsive pull-left" src="<?php echo $location_image; ?>">
									<?php } */?>
									<dl <?php echo (!empty($location_image)) ? 'class="box-image"' : ''; ?>>
										<dd><h4><?php echo $location_name; ?></h4></dd>
										<?php if (config_item('allow_reviews') !== '1') { ?>
											<dd class="text-muted">
												<div class="rating rating-sm">
													<span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star-half-o"></span><span class="fa fa-star-o"></span>
													<span class="small"><?php echo $text_total_review; ?></span>
												</div>
											</dd>
										<?php } ?>
										<dd><span class="text-muted"><?php echo str_replace('<br />', ', ', $location_address); ?></span></dd>
									</dl>
								</div>
								<div class="col-xs-12 box-divider visible-xs"></div>
								<div class="box-two col-xs-12 col-sm-3 col-md-3" style="display: none;">
									<dl>
										<?php if ($opening_status === 'open') { ?>
											<dt><?php echo lang('text_is_opened'); ?></dt>
										<?php } else if ($opening_status === 'opening') { ?>
											<dt class="text-muted"><?php echo sprintf(lang('text_opening_time'), $opening_time); ?></dt>
										<?php } else { ?>
											<dt class="text-muted"><?php echo lang('text_closed'); ?></dt>
										<?php } ?>
										<?php if ($opening_status !== 'closed') { ?>
											<dd class="visible-xs">
												<?php if (!empty($opening_type) AND $opening_type == '24_7') { ?>
													<span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo lang('text_24_7_hour'); ?></span>
												<?php } else if (!empty($opening_time) AND !empty($closing_time)) { ?>
													<span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo $opening_time; ?> - <?php echo $closing_time; ?></span>
												<?php } ?>
											</dd>
										<?php } ?>
										<dd class="text-muted" style="display: none;">
											<?php if ($has_delivery) { ?>
												<?php if ($delivery_status === 'open') { ?>
													<?php echo sprintf(lang('text_delivery_time_info'), sprintf(lang('text_in_minutes'), $delivery_time)); ?>
												<?php } else if ($delivery_status === 'opening') { ?>
													<?php echo sprintf(lang('text_delivery_time_info'), sprintf(lang('text_starts'), $delivery_time)); ?>
												<?php } else { ?>
													<?php echo sprintf(lang('text_delivery_time_info'), lang('text_is_closed')); ?>
												<?php } ?>
											<?php } ?>
										</dd>
										<dd class="text-muted" style="display: none;">
											<?php if ($has_collection) { ?>
												<?php if ($collection_status === 'open') { ?>
													<?php echo sprintf(lang('text_collection_time_info'), sprintf(lang('text_in_minutes'), $collection_time)); ?>
												<?php } else if ($collection_status === 'opening') { ?>
													<?php echo sprintf(lang('text_collection_time_info'), sprintf(lang('text_starts'), $collection_time)); ?>
												<?php } else { ?>
													<?php echo sprintf(lang('text_collection_time_info'), lang('text_is_closed')); ?>
												<?php } ?>
											<?php } ?>
										</dd>
									</dl>
								</div>
								<div class="col-xs-12 box-divider visible-xs"></div>
								<div class="box-three col-xs-12 col-sm-4 col-md-4" style="display: none;">
									<dl>
										<?php if ($opening_status !== 'closed') { ?>
											<dd class="hidden-xs">
												<?php if (!empty($opening_type) AND $opening_type == '24_7') { ?>
													<span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo lang('text_24_7_hour'); ?></span>
												<?php } else if (!empty($opening_time) AND !empty($closing_time)) { ?>
													<span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo $opening_time; ?> - <?php echo $closing_time; ?></span>
												<?php } ?>
											</dd>
										<?php } ?>
										<dd class="text-muted">
											<?php if (!$has_delivery AND $has_collection) { ?>
												<?php echo lang('text_collection_only'); ?>
											<?php } else if ($has_delivery AND !$has_collection) { ?>
												<?php echo lang('text_delivery_only'); ?>
											<?php } else if ($has_delivery AND $has_collection) { ?>
												<?php echo lang('text_both_types'); ?>
											<?php } else { ?>
												<?php echo lang('text_no_types'); ?>
											<?php } ?>
										</dd>
										<?php if ($has_delivery) { ?>
											<dd class="text-muted"><?php echo $text_delivery_condition; ?></dd>
<!--                                            <dd class="text-muted">--><?php //echo ($delivery_charge > 0) ? sprintf(lang('text_delivery_charge'), currency_format($delivery_charge)) : lang('text_free_delivery'); ?><!--</dd>-->
										<?php } ?>
<!--                                        <dd class="text-muted">--><?php //echo lang('text_min_total'); ?><!--: --><?php //echo currency_format($min_total); ?><!--</dd>-->
									</dl>
							   </div>
							</div>
						
					</div>
				
			<?php } ?>
	
<script type="text/javascript"><!--
	$(document).ready(function() {
		$('.review-toggle').on('click', function() {
			$('a[href="#reviews"]').tab('show');
		});
	});

	function toggleLocalSearch() {
		if ($('.panel-local .panel-heading .local-search').is(":visible")) {
			$('.panel-local .panel-heading .local-search').slideUp();
			$('.panel-local .panel-heading .local-change').slideDown();
		} else {
			$('.panel-local .panel-heading .local-search').slideDown();
			$('.panel-local .panel-heading .local-change').slideUp();
		}
	}

	function searchLocal() {
		var search_query = $('input[name=\'search_query\']').val();
		//var  keywords= $('input[name=\'keyword\']').val();
		var  type= $('select[name=\'location_type\']').val();
		//var  booking_date= $('input[name=\'booking_date\']').val();

		//alert(keywords);return false;
		if(search_query != '')
		{	
			/*if(keywords != '' && booking_date != '')
			{
				var url = js_site_url('locations') + '?search=' + search_query + '&keyword=' + keywords + '&booking_date=' + booking_date;
			}
			else if (keywords != '')
			{
				var url = js_site_url('locations') + '?search=' + search_query + '&keyword=' + keywords;
			}
			else if(booking_date != '')
			{
				var url = js_site_url('locations') + '?search=' + search_query + '&booking_date=' + booking_date;
			}
			else
			{*/
				var url = js_site_url('locations') + '?search=' + search_query;	
			//}
			
			window.location.href= url + '&type=' + type;
			/*$.ajax({
				url: js_site_url('locations'),
				type: 'POST',
				data: 'search=' + search_query,
				dataType: 'json',
				success: function(json) {
					//console.log(json);return false;
					updateLocalBox(json);
				}
			});*/
		}
		else
		{
			 document.getElementById("ent_loc").style.display = 'block';
			//alert('select any one field');

		}
	}

	function updateLocalBox(json) {
		var alert_close = '<button type="button" class="close top-35" data-dismiss="alert" aria-hidden="true">&times;</button>';
		var local_alert = $('#local-alert .local-alert');
		var alert_message = '';

		if (json['redirect']) {
			window.location.href = json['redirect'];
		}

		if (json['error']) {
			alert_message = '<div class="alert">' + alert_close + json['error'] + '</div>';
		}

		if (json['success']) {
			alert_message = '<div class="alert">' + alert_close + json['success'] + '</div>';
		}

		if ($('#cart-box').is(':visible')) {
			$('#cart-box').load(js_site_url('cart_module/cart_module #cart-box > *'), function (response) {
				if (alert_message != '') {
					local_alert.empty();
					local_alert.append(alert_message);
					$('#local-alert').fadeIn('slow').fadeTo('fast', 0.5).fadeTo('fast', 1.0);
					$('html, body').animate({scrollTop: 0}, 300);
				}
			});
		} else {
			if (alert_message != '') {
				local_alert.empty();
				local_alert.append(alert_message);
				$('#local-alert').fadeIn('slow').fadeTo('fast', 0.5).fadeTo('fast', 1.0);
				$('html, body').animate({scrollTop: 0}, 300);
			}
		}
	}
//-->
</script>

<script>
    window.onload = function(e){ 
        getLocation();
       
       };
	function getLocation() {
		  if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(showPosition);
		  } else { 
		      alert("Geolocation is not supported by this browser.");
		  }
	}
    function showPosition(position) {
         var geocoder = new google.maps.Geocoder;
          geocodeLatLng(geocoder, position.coords.latitude , position.coords.longitude);
          "<br>Longitude: " + position.coords.longitude;
    }
    function geocodeLatLng(geocoder, lat ,lng) {
        var latlng = {lat: parseFloat(lat), lng: parseFloat(lng)};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
          	if (results[0]) {
            	$("#search_query").val(results[0].formatted_address);
            } else {
              console.log('No results found');
            }
          } else {
            console.log('Geocoder failed due to: ' + status);
          }
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->config->item('maps_api_key')?>&libraries=places&callback=initAutocomplete" async defer></script>
    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      

      function initAutocomplete() 
      {
      	var placeSearch, autocomplete;
      	var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      	};
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('search_query')),
            {
              types: ['geocode']
              // componentRestrictions: { country: "au" }
            });

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }
      $( function() {
      		

	    	$( "#datepicker" ).datepicker({
				 autoclose:true,
				 format : "dd-mm-yyyy",
				 startDate: new Date() ,
                 orientation: 'bottom'  ,
                 todayHighlight: 'true'
			});

			$('#datepicker').datepicker(
      			'setDate', new Date()
      			);
    
  		});

    </script>
    
  
</div>

/* latin-ext */
@font-face {
  font-family: 'Quattrocento Sans';
  font-style: normal;
  font-weight: 400;
  src: local('Quattrocento Sans'), local('QuattrocentoSans'), url(http://fonts.gstatic.com/s/quattrocentosans/v9/efd6FGWWGX5Z3ztwLBrG9T48MEBspdEKklcQvcIk8pU.woff2) format('woff2');
  unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Quattrocento Sans';
  font-style: normal;
  font-weight: 400;
  src: local('Quattrocento Sans'), local('QuattrocentoSans'), url(http://fonts.gstatic.com/s/quattrocentosans/v9/efd6FGWWGX5Z3ztwLBrG9cZ4HySTEWshgORbPp2tk8k.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
}
/* latin-ext */
@font-face {
  font-family: 'Quattrocento Sans';
  font-style: normal;
  font-weight: 700;
  src: local('Quattrocento Sans Bold'), local('QuattrocentoSans-Bold'), url(http://fonts.gstatic.com/s/quattrocentosans/v9/tXSgPxDl7Lk8Zr_5qX8FIdqgfwRMvy6EDFppit6Do18.woff2) format('woff2');
  unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Quattrocento Sans';
  font-style: normal;
  font-weight: 700;
  src: local('Quattrocento Sans Bold'), local('QuattrocentoSans-Bold'), url(http://fonts.gstatic.com/s/quattrocentosans/v9/tXSgPxDl7Lk8Zr_5qX8FIbvMLSVzqOGkoxdgTSsKqWM.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
}

(function (factory, jQuery) {
  if (typeof define === 'function' && define.amd) {
    define('datepicker.de-DE', ['jquery'], factory);
  } else if (typeof exports === 'object') {
    factory(require('jquery'));
  } else {
    factory(jQuery);
  }
})(function ($) {
  $.fn.datepicker.lang['de-DE'] = {
    days: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
    daysMin: ['Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vri', 'Zat'],
    months: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
    monthsShort: ['Jan', 'Feb', 'Maa', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
    yearSuffix: '',
    monthSuffix: '',
    todaySuffix: 'Vandaag',
    dateInputPlaceholder: 'Selecteer een datum',
    rangeStartInputPlaceholder: 'Startdatum',
    rangeEndPlaceholder: 'Einddatum',
    dateTimeInputPlaceholder: 'Select time',
    rangeStartTimeInputPlaceholder: 'Start Time',
    rangeEndTimeInputPlaceholder: 'End Time',
    nowDateButton: 'Nu',
    confirmDateButton: 'Bevestigen',
    cancelTimeButton: 'Annuleer',
    clearButton: 'Doorzichtig'
  };
}, window.jQuery);

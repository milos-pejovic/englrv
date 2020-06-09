// Hero image html

var heroImageHtml = '<div class="hero-image-wrapper">';
heroImageHtml += '<img class="exercise-hero-image" src="###image-url###" alt="###alt-text###" />';
heroImageHtml += '</div>';

// Text html

var textHtml = '<div class="text-wrap">';
textHtml += '<p>###text###</p>';
textHtml += '</div>';
  
// Text questions html

var textQuestions = '<div class="text-questions-wrap">';
textQuestions += '###questions###';
textQuestions += '</div>';

// Text question input field

var textQuestionInputField = '<input type="text" ';
textQuestionInputField += 'class="exercise-text-question-input-field" ';
textQuestionInputField += 'data-answers="###answers###" ';
textQuestionInputField += ' />';

/**
 * ==========================================================================================
 * Renderer
 * ==========================================================================================
 */

var renderer = {

  // ========================================================================================
  // Hero image

  heroImage : function(data) {
    return false;
    console.warn('render HERO IMAGE');

    var html = heroImageHtml;
    html = html.replace('###image-url###', '/images/back.jpg');
    $('.exercise-data-wrapper').html($('.exercise-data-wrapper').html() + html);
  },

  // ========================================================================================
  // Text

  text : function(data) {
    console.warn('render TEXT');

    var html = textHtml;
    html = html.replace('###text###', data.text);
    $('.exercise-data-wrapper').html($('.exercise-data-wrapper').html() + html);
  },

  // ========================================================================================
  // Text questions

  textQuestions : function(data) {
    console.log('render TEXT QUESTIONS');
    var html = '';
    var questionsLength = data.questions.length;

    // Each Question

    for (var i = 0; i < questionsLength; i++){
      var questionHtml = '<p>' + (i + 1) + '. ' + data.questions[i].text + '</p>';
      var numberOfFields = Object.keys(data.questions[i].answers).length;

      // Each input field

      for (var j = 0; j < numberOfFields; j++) {
        var inputFieldHtml = textQuestionInputField;

        // each asnwer

        questionHtml = questionHtml.replace('###' + (j + 1) + '###', textQuestionInputField);
      }

      html += questionHtml; 
    }

    // console.log(data);

    $('.exercise-data-wrapper').html($('.exercise-data-wrapper').html() + html);
  },

};


$('body').delegate('.exercise-text-question-input-field', 'input', function() {
  var value = $(this).val();
  var inputFieldWidth = value.length * 10;
  if (inputFieldWidth < 50){
    inputFieldWidth = 50;
  }
  $(this).css('width', inputFieldWidth);
});
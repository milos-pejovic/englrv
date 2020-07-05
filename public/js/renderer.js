// Hero image html

var heroImageHtml = '<div class="hero-image-wrapper">';
heroImageHtml += '<img class="exercise-hero-image" src="###image-url###" alt="###alt-text###" />';
heroImageHtml += '</div>';

// Text html

var textHtml = '<div class="text-wrap">';
textHtml += '<p>###text###</p>';
textHtml += '</div>';
  
// Given words html

var givenWords = '<div class="given-words-wrap">';
givenWords += '###words###';
givenWords += '</div>';

// Text questions html

var textQuestions = '<div class="text-questions-wrap">';
textQuestions += '###questions###';
textQuestions += '</div>';

// Text question input field

var textQuestionInputField = '<span class="text-question-wrap">';
textQuestionInputField += '<input type="text" ';
textQuestionInputField += 'class="exercise-text-question-input-field" ';
textQuestionInputField += 'data-answers="###answers###" data-example="###example###" ';
textQuestionInputField += ' />';
textQuestionInputField += '<span class="answer-validity correct"><i class="fas fa-check"></i></span>';
textQuestionInputField += '<span class="answer-validity incorrect"><i class="fas fa-times"></i></span>';
textQuestionInputField += '</span>';



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
  // Given words

  givenWords : function(data) {
    var wordsHtml = '';
    var wordsLength = data.words.length;

    for (var i = 0; i < wordsLength; i++) {
      wordsHtml += '<span class="given-words">' + data.words[i] + '</span>';
    }
    
    var html = givenWords.replace('###words###', wordsHtml);
    $('.exercise-data-wrapper').html($('.exercise-data-wrapper').html() + html);
  },

  // ========================================================================================
  // Text questions

  textQuestions : function(data) {
    console.log('render TEXT QUESTIONS');
    var html = '';
    var questionsLength = data.questions.length;

    console.log(data);

    // Each Question

    for (var i = 0; i < questionsLength; i++){
      var questionHtml = '<p>' + (i + 1) + '. ' + data.questions[i].text + '</p>';
      var numberOfFields = Object.keys(data.questions[i].answers).length;

      // Each input field

      for (var j = 0; j < numberOfFields; j++) {

        // Each answer

        questionHtml = questionHtml.replace('###' + (j + 1) + '###', textQuestionInputField);
        questionHtml = questionHtml.replace('###answers###', data.questions[i].answers[(j + 1)].join('|'));

        var exampleValue = false;

        if (data.questions[i].example) {
          exampleValue = true;
        }

        questionHtml = questionHtml.replace('###example###', exampleValue);
      }

      html += questionHtml; 
    }

    html += '<button class="btn btn-primary answer-controls check" data-toggle="modal" data-target="#exampleModal">Check</button>';
    html += '<button class="btn btn-primary answer-controls show">Show</button>';
    html += '<button class="btn btn-primary answer-controls clear">Clear</button>';

    $('.exercise-data-wrapper').html($('.exercise-data-wrapper').html() + html);
  },

};

// Dynamically modify input field width 

function modifyInputFieldWidth(element) {
  var value = element.val();
  var inputFieldWidth = value.length * 10;
  if (inputFieldWidth < 50){
    inputFieldWidth = 50;
  }
  element.css('width', inputFieldWidth);
}

$('body').delegate('.exercise-text-question-input-field', 'input', function() {
  modifyInputFieldWidth($(this));
  removeAllMarkings();
});

// Mark as Correct

function markCorrect(element) {
  element.css('color', 'green');
  element.parents('.text-question-wrap').find('.answer-validity.incorrect').hide();
  element.parents('.text-question-wrap').find('.answer-validity.correct').show();
}

// Mark as Wrong

function markWrong(element) {
  element.css('color', 'red');
  element.parents('.text-question-wrap').find('.answer-validity.correct').hide();
  element.parents('.text-question-wrap').find('.answer-validity.incorrect').show();
}

// Clear

function clear(element) {
  removeCorrection(element);
  element.val('');
};

// Removes correction marking

function removeCorrection(element) {
  element.css('color', 'black');
  element.parents('.text-question-wrap').find('.answer-validity.correct').hide();
  element.parents('.text-question-wrap').find('.answer-validity.incorrect').hide();
}

// Remove correction marking from all fields

function removeAllMarkings() {
  $('.exercise-text-question-input-field').each(function() {
    removeCorrection($(this));
  });
}

// "Check" button click event handler

$('body').delegate('.answer-controls.check', 'click', function() {
  $('.my-modal-wrap.check-answers').show();
});

// My Modal Check answers Ok button

$('.my-modal-wrap.check-answers .ok-button').click(function() {
  $('.exercise-text-question-input-field').each(function() {

    if ($(this).data('example')) {
      return;
    }

    var userAnswer = $(this).val();
    var correctAnswers = $(this).data('answers').split('|');

    if (correctAnswers.indexOf(userAnswer) != -1 || $(this).data('answers').replace('|', ' | ') == userAnswer) {
      markCorrect($(this));
    } else {
      markWrong($(this));
    }
  });

  $(this).parents('.my-modal-wrap').hide();
});

// My Modal Check answers Cancel button

$('.my-modal-wrap.check-answers .cancel-button').click(function() {
  $(this).parents('.my-modal-wrap').hide();
});

// "Clear" button click event handler

$('body').delegate('.answer-controls.clear', 'click', function() {
  $('.my-modal-wrap.clear-answers').show();
});

$('.my-modal-wrap.clear-answers .ok-button').click(function() {
  $('.exercise-text-question-input-field').each(function() {
    if ($(this).data('example')) {
      return;
    }
    clear($(this));
  });
  $(this).parents('.my-modal-wrap').hide();
});

$('.my-modal-wrap.clear-answers .cancel-button').click(function() {
  $(this).parents('.my-modal-wrap').hide();
});

// "Show" button click event handler

$('body').delegate('.answer-controls.show', 'click', function() {
  $('.my-modal-wrap.show-answers').show();
});

$('.my-modal-wrap.show-answers .ok-button').click(function() {
  removeAllMarkings();
  $('.exercise-text-question-input-field').each(function() {
    if ($(this).data('example')) {
      return;
    }
    var answers = $(this).data('answers').replace('|', ' | ');
    $(this).val(answers);
    modifyInputFieldWidth($(this));
  });
  $(this).parents('.my-modal-wrap').hide();
});

$('.my-modal-wrap.show-answers .cancel-button').click(function() {
  $(this).parents('.my-modal-wrap').hide();
});

// On Load

$( document ).ready(function(){
  $('.exercise-text-question-input-field').each(function() {
    if ($(this).data('example')) {
      $(this).val($(this).data('answers').replace('|', ' | '));
      modifyInputFieldWidth($(this));
      $(this).css({
        'font-style' : 'italic',
        'color' : 'gray'
      });
      $(this).prop('readonly', true);
    }
  });
});


$(document).ready(function() {
	"use strict";
	var pattern = /^[a-z0-9][a-z0-9\._-]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i;
	var mail = $('input[name=email]');
	var task = $('input[name=task]');
	var pass = $('input[type=password]');
	mail.blur(function() {
		if (mail.val() != '') {
		    if (mail.val().search(pattern) == 0) {
		        $('#email_message_error').text('');
		        $('input[type=submit]').attr('disabled', false);
		        $('#email_message_error').removeClass('active');
		    } else {
		        $('#email_message_error').text('Не правильный email');
		        $('input[type=submit]').attr('disabled', true);
		        $('#email_message_error').addClass('active');
		    }
		} else {
		    $('#email_message_error').text('Введите Ваш email');
		    $('input[type=submit]').attr('disabled', true);
		    $('#email_message_error').addClass('active');
    	}
    });

	task.blur(function() {
		if (task.val() != '') {
			if (task.val().length > 9) {
		        $('#task_message_error').text('');
		        $('input[type=submit]').attr('disabled', false);
		        $('#task_message_error').removeClass('active');
		    } else {
		    	$('#task_message_error').text('Минимальная длина текст задачи 10 символов');
		        $('input[type=submit]').attr('disabled', true);
		        $('#task_message_error').addClass('active');
		    }
		} else {
		    $('#task_message_error').text('Введите текст задачи');
		    $('input[type=submit]').attr('disabled', true);
		    $('#task_message_error').addClass('active');
		}
    });

    pass.blur(function() {
    	if (pass.val() != '') {
    		if (pass.val().length > 7) {
    			$('#pass_message_error').text('');
    			$('input[type=submit]').attr('disabled', false);
    			$('#pass_message_error').removeClass('active');
    		} else {
    			$('#pass_message_error').text('Минимальная длина пароля 8 символов');
		        $('input[type=submit]').attr('disabled', true);
		        $('#pass_message_error').addClass('active');
    		}
    	} else {
		    $('#pass_message_error').text('Введите пароль');
		    $('input[type=submit]').attr('disabled', true);
		    $('#pass_message_error').addClass('active');
		}
    });

    $(".admin_popup").click(function() {
    	$('.hidden_form').show();
    });
    
    $('.close').click(function() {
    	$('.hidden_form').hide();
    });
    
    $("#select_sort").click(function() {
    	//$("#sorting_list").slideToggle(200);
    	$("#sorting_list").show(200);
    });
});
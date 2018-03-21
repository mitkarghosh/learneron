//banner 
$(document).ready(function () {
	"use strict";
	/*$('.form-control[data-provide="datepicker"]').datepicker({
		format: 'dd/mm/yy'
	});*/

	$('.mob-menu').click(function () {
		$('.site-nav').fadeIn('fast');

	});

	$('.menu-close').click(function () {
		$('.site-nav').fadeOut('fast');
	});
	
	$('.login-modal-lg').on('hidden.bs.modal', function () {
			$('body').removeClass('modal-open');
	});
//	
//	$('.register-modal-lg').on('shown.bs.modal', function () {
//
//		$('.login-modal-lg').hide();
//
//		$('.login-modal-lg').on('hidden.bs.modal', function () {
//			$('body').addClass('modal-open');
//			$('.modal-backdrop').remove();
//			$('body').removeAttr('style');	
//		});
//
//	});
//
//
//	$('.register-modal-lg').on('hidden.bs.modal', function () {
//        $('body').removeClass('modal-open');
//		$('.modal-backdrop').remove();
//		$('body').removeAttr('style');	
//
//	});
	

$('.openRegister').click(function(){
	$('.form-conatiner.register-from').fadeIn();
	$('.form-conatiner.login-form').fadeOut();
});
	
$('.openLogin').click(function(){
	
	$('.form-conatiner.login-form').fadeIn();
	$('.form-conatiner.register-from').fadeOut();
});

$('.openRegisterCommentvote').click(function(){
	$('.form-conatiner.register-from-commentvote').fadeIn();
	$('.form-conatiner.login-form-commentvote').fadeOut();
});
	
$('.openLoginCommentvote').click(function(){
	
	$('.form-conatiner.login-form-commentvote').fadeIn();
	$('.form-conatiner.register-from-commentvote').fadeOut();
});
	


	(function ($) {
		if (!$.curCSS) {
			$.curCSS = $.css;
		}
	})(jQuery);



});

function searchAndHighlight(searchTerm, selector, highlightClass, removePreviousHighlights) {
	if(searchTerm) {
        //var wholeWordOnly = new RegExp("\\g"+searchTerm+"\\g","ig"); //matches whole word only
        //var anyCharacter = new RegExp("\\g["+searchTerm+"]\\g","ig"); //matches any word with any of search chars characters
        var selector = selector || "body",                             //use body as selector if none provided
            searchTermRegEx = new RegExp("("+searchTerm+")","gi"),
            matches = 0,
            helper = {};
        helper.doHighlight = function(node, searchTerm){
            if(node.nodeType === 3) {
                if(node.nodeValue.match(searchTermRegEx)){
                    matches++;
                    var tempNode = document.createElement('span');
                    tempNode.innerHTML = node.nodeValue.replace(searchTermRegEx, "<span class="+highlightClass+">$1</span>");
                    node.parentNode.insertBefore(tempNode, node );
                    node.parentNode.removeChild(node);
                }
            }
            else if(node.nodeType === 1 && node.childNodes && !/(style|script)/i.test(node.tagName)) {
                $.each(node.childNodes, function(i,v){
                    helper.doHighlight(node.childNodes[i], searchTerm);
                });
            }
        };
        if(removePreviousHighlights) {
            $('.'+highlightClass).each(function(i,v){
                var $parent = $(this).parent();
                $(this).contents().unwrap();
                $parent.get(0).normalize();
            });
        }
 
        $.each($(selector).children(), function(index,val){
            helper.doHighlight(this, searchTerm);
        });
        return matches;
    }
    return false;
}
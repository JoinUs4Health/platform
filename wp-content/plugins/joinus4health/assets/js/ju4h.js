function checkEmail(emailAddress) {
    var sQtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
    var sDtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
    var sAtom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
    var sQuotedPair = '\\x5c[\\x00-\\x7f]';
    var sDomainLiteral = '\\x5b(' + sDtext + '|' + sQuotedPair + ')*\\x5d';
    var sQuotedString = '\\x22(' + sQtext + '|' + sQuotedPair + ')*\\x22';
    var sDomain_ref = sAtom;
    var sSubDomain = '(' + sDomain_ref + '|' + sDomainLiteral + ')';
    var sWord = '(' + sAtom + '|' + sQuotedString + ')';
    var sDomain = sSubDomain + '(\\x2e' + sSubDomain + ')*';
    var sLocalPart = sWord + '(\\x2e' + sWord + ')*';
    var sAddrSpec = sLocalPart + '\\x40' + sDomain; // complete RFC822 email address spec
    var sValidEmail = '^' + sAddrSpec + '$'; // as whole string

    var reValidEmail = new RegExp(sValidEmail);

    return reValidEmail.test(emailAddress);
}

function check_pass_strength() {
        var pass1 = $( '.password-entry' ).val(),
            pass2 = $( '.password-entry-confirm' ).val(),
            strength;

        // Reset classes and result text
        $( '#pass-strength-result' ).removeClass( 'short bad good strong' );
        if ( ! pass1 ) {
                $( '#pass-strength-result' ).html( pwsL10n.empty );
                return;
        }

        // wp.passwordStrength.userInputBlacklist() has been deprecated in WP 5.5.0.
        if ( 'function' === typeof wp.passwordStrength.userInputDisallowedList ) {
                strength = wp.passwordStrength.meter( pass1, wp.passwordStrength.userInputDisallowedList(), pass2 );
        } else {
                strength = wp.passwordStrength.meter( pass1, wp.passwordStrength.userInputBlacklist(), pass2 );
        }

        switch ( strength ) {
                case 2:
                        $( '#pass-strength-result' ).addClass( 'bad' ).html( pwsL10n.bad );
                        break;
                case 3:
                        $( '#pass-strength-result' ).addClass( 'good' ).html( pwsL10n.good );
                        break;
                case 4:
                        $( '#pass-strength-result' ).addClass( 'strong' ).html( pwsL10n.strong );
                        break;
                case 5:
                        $( '#pass-strength-result' ).addClass( 'short' ).html( pwsL10n.mismatch );
                        break;
                default:
                        $( '#pass-strength-result' ).addClass( 'short' ).html( pwsL10n['short'] );
                        break;
        }
}


$(document).ready(function() {
    if ($('#signup_form').length || $('#profile-edit-form').length) {
        var signup_errors = []; //initially errors
        
        $("#field_1").attr('disabled', true);
        $('div.field_1').hide();
        $('#signup_username').attr('maxlength', 42);
        $('#field_1').attr('maxlength', 42);

        setTimeout(signup_check_is_valid, 1000);
        
        function signup_check_is_valid() {
            check_pass_strength();
            errors = [];
            
            if ($('#signup_username').val().length == 0)
                errors.push(error_username_empty);

            if ($('#signup_email').val().length == 0)
                errors.push(error_email_empty);
            else if (!checkEmail($('#signup_email').val()))
                errors.push(error_email_invalid);

            if ($('#signup_password').val().length == 0)
                errors.push(error_password_empty);
            else if ($('#signup_password_confirm').val().length == 0)
                errors.push(error_password_confirm_empty);
            else if ($('#signup_password').val() != $('#signup_password_confirm').val())
                errors.push(error_password_confirm_mismatch);
//            else if (!($('#pass-strength-result').hasClass('strong')))
//                errors.push(error_password_too_weak);
            
            signup_errors = errors;
            setTimeout(signup_check_is_valid, 1000);
        }
        
        $("#signup_submit").click(function(e) {
            if (signup_errors.length > 0) {
                signup_errors_str = '';
                for (signup_error in signup_errors) {
                    signup_errors_str += '- '+signup_errors[signup_error]+"\n";
                }
                alert(signup_errors_str);
                e.preventDefault();
            }
        });
    }
    
    if ($('#settings-form').length) {
        var settings_errors = []; //initially errors
        
        setTimeout(settings_is_valid, 1000);

        function settings_is_valid() {
            check_pass_strength();
            errors = [];
            
            if ($('#pass1').val().length > 0) {
                if ($('#pass2').val().length == 0)
                    errors.push(error_password_confirm_empty);
                else if ($('#pass1').val() != $('#pass2').val())
                    errors.push(error_password_confirm_mismatch);
//                else if (!($('#pass-strength-result').hasClass('strong')))
//                    errors.push(error_password_too_weak);
            }
            
            settings_errors = errors;
            setTimeout(settings_is_valid, 1000);
        }
        
        $("#settings-form #submit").click(function(e) {
            if (settings_errors.length > 0) {
                settings_errors_str = '';
                for (settings_error in settings_errors) {
                    settings_errors_str += '- '+settings_errors[settings_error]+"\n";
                }
                alert(settings_errors_str);
                e.preventDefault();
            }
        });
    }
    
    $(".site-header-primary-section-right > .ast-builder-menu > .ast-main-header-bar-alignment").append(
        '<div class="main-header-bar-navigation">'+
            '<nav class="ast-flex-grow-1 navigation-accessibility site-header-focus-item" id="site-navigation" aria-label="Site Navigation" itemtype="https://schema.org/SiteNavigationElement" itemscope="itemscope">'+
                '<div class="main-navigation ast-inline-flex">'+
                    '<ul id="ast-hf-menu-1" class="main-header-menu ast-nav-menu ast-flex  submenu-with-border stack-on-mobile" aria-expanded="false"></ul>'+
                '</div>'+
            '</nav>'+
        '</div>'
    );

    $("#ast-hf-menu-1").append(
        '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">'+
            '<a href="'+home_url+'" class="menu-link">'+home_text+ 
                '<span role="presentation" class="dropdown-menu-toggle" tabindex="0">'+
                    '<span class="ast-icon icon-arrow">'+
                    '</span>'+
                '</span>'+
            '</a>'+
        '</li>'
    );
    
    $("#ast-hf-menu-1").append(
        '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">'+
            '<a href="#" class="menu-link">'+join_us_text+ 
                '<span role="presentation" class="dropdown-menu-toggle" tabindex="0">'+
                    '<span class="ast-icon icon-arrow">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                            '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
            '</a>'+
            '<button class="ast-menu-toggle" aria-expanded="false">'+
                '<span class="screen-reader-text">Menu Toggle</span>'+
                '<span class="ast-icon icon-arrow">'+
                    '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                        '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                    '</svg>'+
                '</span>'+
            '</button>'+
            '<ul class="sub-menu" id="join-us">'+
            '</ul>'+
        '</li>'
    );
    
    for (item in join_us_items) {
        $("#join-us").append(
            '<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item">'+
                '<a href="'+join_us_items[item].url+'" aria-current="page" class="menu-link">'+
                    '<span class="ast-icon icon-arrow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                            '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                        '</svg>'+
                    '</span>'+join_us_items[item].text+
                '</a>'+
            '</li>'
        );
    }
    
    if (!is_logged_in) {
        $("#ast-hf-menu-1").append(
            '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">'+
                '<a href="'+sign_up_url+'" class="menu-link">'+sign_up_text+ 
                    '<span role="presentation" class="dropdown-menu-toggle" tabindex="0">'+
                    '</span>'+
                '</a>'+
                '<button class="ast-menu-toggle" aria-expanded="false">'+
                    '<span class="screen-reader-text">Menu Toggle</span>'+
                '</button>'+
            '</li>'
        );
    }
    
    if (!is_logged_in) {
        $("#ast-hf-menu-1").append(
            '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">'+
                '<a href="'+sign_in_url+'" class="menu-link">'+sign_in_text+ 
                    '<span role="presentation" class="dropdown-menu-toggle" tabindex="0">'+
                    '</span>'+
                '</a>'+
                '<button class="ast-menu-toggle" aria-expanded="false">'+
                    '<span class="screen-reader-text">Menu Toggle</span>'+
                '</button>'+
            '</li>'
        );
    }
    
    $("#ast-hf-menu-1").append(
        '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children">'+
            '<a href="#" class="menu-link"><img src="'+possible_languages[language].url+'" style="margin-right: 10px">'+possible_languages[language].text+ 
                '<span role="presentation" class="dropdown-menu-toggle" tabindex="0">'+
                    '<span class="ast-icon icon-arrow">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                            '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
            '</a>'+
            '<button class="ast-menu-toggle" aria-expanded="false">'+
                '<span class="screen-reader-text">Menu Toggle</span>'+
                '<span class="ast-icon icon-arrow">'+
                    '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                        '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                    '</svg>'+
                '</span>'+
            '</button>'+
            '<ul class="sub-menu" id="languages">'+
            '</ul>'+
        '</li>'
    );
    
    for (possible_language in possible_languages) {
        $("#languages").append(
            '<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item">'+
                '<a href="#" data-lang="'+possible_language+'" aria-current="page" class="menu-link set-language">'+
                    '<span class="ast-icon icon-arrow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                            '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                        '</svg>'+
                    '</span><img src="'+possible_languages[possible_language].url+'" style="margin-right: 10px">'+possible_languages[possible_language].text+
                '</a>'+
            '</li>'
        );
    }
            
    $(".ast-mobile-header-content > .ast-builder-menu-mobile > .ast-main-header-bar-alignment").append(
        '<div class="main-header-bar-navigation toggle-off">'+
            '<nav class="site-navigation" id="ast-mobile-site-navigation" itemtype="https://schema.org/SiteNavigationElement" itemscope="itemscope" aria-label="Site Navigation">'+
                '<div id="ast-hf-mobile-menu" class="main-navigation">'+
                    '<ul class="main-header-menu ast-nav-menu ast-flex  submenu-with-border astra-menu-animation-fade  stack-on-mobile" id="ast-hf-menu-mobile-1">'+
                    '</ul>'+
                '</div>'+
            '</nav>'+
        '</div>'
    );
    
    $("#ast-hf-menu-mobile-1").append(
        '<li class="page_item menu-item">'+
            '<a href="'+home_url+'" class="menu-link">'+home_text+'</a>'+
        '</li>'
    );

    $("#ast-hf-menu-mobile-1").append(
        '<li class="page_item menu-item-has-children menu-item">'+
            '<a href="#" class="menu-link">'+join_us_text+
                '<span role="presentation" class="dropdown-menu-toggle">'+
                    '<span class="ast-icon icon-arrow">'+
                        '<svg class="ast-arrow-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                            '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
            '</a>'+
            '<button class="ast-menu-toggle" aria-expanded="false">'+
                '<span class="screen-reader-text">Menu Toggle</span>'+
                '<span class="ast-icon icon-arrow">'+
                    '<svg class="ast-arrow-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                        '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                    '</svg>'+
                '</span>'+
            '</button>'+
            '<ul class="children sub-menu" style="display: none;" id="mobile-join_us">'+
            '</ul>'+
        '</li>'
    );
    
    for (item in join_us_items) {
        $("#mobile-join_us").append(
            '<li class="page_item menu-item">'+
                '<a href="'+join_us_items[item].url+'" class="menu-link">'+join_us_items[item].text+'</a>'+
            '</li>'
        );
    }
        
    if (!is_logged_in) {
        $("#ast-hf-menu-mobile-1").append(
            '<li class="page_item menu-item">'+
                '<a href="'+sign_up_url+'" class="menu-link">'+sign_up_text+'</a>'+
            '</li>'
        );
    }
       
    if (!is_logged_in) {
        $("#ast-hf-menu-mobile-1").append(
            '<li class="page_item menu-item">'+
                '<a href="'+sign_in_url+'" class="menu-link">'+sign_in_text+'</a>'+
            '</li>'
        );
    }

    $("#ast-hf-menu-mobile-1").append(
        '<li class="page_item menu-item-has-children menu-item">'+
            '<a href="#" class="menu-link">'+possible_languages[language].text+
                '<span role="presentation" class="dropdown-menu-toggle">'+
                    '<span class="ast-icon icon-arrow">'+
                        '<svg class="ast-arrow-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                            '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
            '</a>'+
            '<button class="ast-menu-toggle" aria-expanded="false">'+
                '<span class="screen-reader-text">Menu Toggle</span>'+
                '<span class="ast-icon icon-arrow">'+
                    '<svg class="ast-arrow-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="26px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve">'+
                        '<path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>'+
                    '</svg>'+
                '</span>'+
            '</button>'+
            '<ul class="children sub-menu" style="display: none;" id="mobile-languages">'+
            '</ul>'+
        '</li>'
    );
    
    for (possible_language in possible_languages) {
        $("#mobile-languages").append(
            '<li class="page_item menu-item">'+
                '<a href="#"  data-lang="'+possible_language+'" class="set-language menu-link">'+possible_languages[possible_language].text+'</a>'+
            '</li>'
        );
    }
    
    $('.set-language').click(function(e){
        e.preventDefault();
        language = $(this).attr('data-lang');
        Cookies.set('language', language, { expires: 7 });
        window.location.reload();
    });

    var divElement = jQuery("div.field_11 fieldset div");
    if (divElement !== undefined) {
        divHtml = divElement.html();
        if (divHtml !== undefined) {
            divFixed = divHtml.replace(/\./g, " and confirm that I am at least 16 years old.");
            divElement.html(divFixed);
        }
    }
    
    $('.comment .container .txt .readmore').click(function(e) {
        e.preventDefault();
        
        divTxt = $(this).parent().parent().children('div')[2];
        divTxtFull = $(this).parent().parent().children('div')[3];
        
        $(divTxt).hide();
        $(divTxtFull).show();
    });
    
    $("textarea").each(function () {
      this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
    }).on("input", function () {
      this.style.height = 0;
      this.style.height = (this.scrollHeight) + "px";
    });    
});
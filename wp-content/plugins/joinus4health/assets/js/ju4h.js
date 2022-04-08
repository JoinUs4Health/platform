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
        $("#field_1").attr('disabled', true);
        $('div.field_1').hide();
        $('#signup_submit').attr('disabled', true);
        $('#signup_username').attr('maxlength', 20);
        $('#field_1').attr('maxlength', 20);

        setTimeout(signup_check_is_valid, 5000);
        
        function signup_check_is_valid() {
            check_pass_strength();
            errors = 0;
            
            if ($('#signup_username').val().length == 0)
                errors++;

            if ($('#signup_username').val().length > 20)
                errors++;

            if ($('#signup_password').val().length == 0)
                errors++;

            if ($('#signup_password_confirm').val().length == 0)
                errors++;

            if ($('#signup_password').val() != $('#signup_password_confirm').val())
                errors++;

            if (!($('#pass-strength-result').hasClass('strong')))
                errors++;

            if (errors == 0) {
                $('#signup_submit').removeAttr('disabled');
            } else {
                $('#signup_submit').attr('disabled', true);
            }
    
            setTimeout(signup_check_is_valid, 1000);
        }
    }
    
    if ($('#settings-form').length) {
        setTimeout(settings_is_valid, 5000);

        function settings_is_valid() {
            console.log("ok");
            check_pass_strength();
            errors = 0;
            
            if ($('#pass1').val().length > 0) {
                if ($('#pass1').val() != $('#pass2').val())
                    errors++;

                if (!($('#pass-strength-result').hasClass('strong')))
                    errors++;
            }
            
            if (errors == 0) {
                $('#settings-form #submit').removeAttr('disabled');
            } else {
                $('#settings-form #submit').attr('disabled', true);
            }
            
            console.log("ok2");
            setTimeout(settings_is_valid, 1000);
        }
    }
    
    $(".ast-main-header-bar-alignment").append(
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
    
    $('.set-language').click(function(e){
        e.preventDefault();
        language = $(this).attr('data-lang');
        Cookies.set('language', language, { expires: 7 });
        window.location.reload();
    });
});
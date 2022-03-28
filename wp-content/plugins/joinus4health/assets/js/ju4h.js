$(document).ready(function() {
    
    if ($('#signup_form')) {
        $('#signup_submit').attr('disabled', true);
        $('#signup_username').attr('maxlength', 20);
        $('#field_1').attr('maxlength', 20);

        var signup_text_fields = ['signup_username', 'signup_email', 'signup_password', 'signup_password_confirm', 'field_1'];
        for (index in signup_text_fields) {
            $('#'+signup_text_fields[index]).keydown(function(e) {
                signup_check_is_valid_action();
            });
            $('#'+signup_text_fields[index]).keyup(function(e) {
                signup_check_is_valid_action();
            });
        }

        function signup_check_is_valid() {
            if ($('#signup_username').val().trim().length == 0)
                return false;

            if ($('#signup_username').val().trim().length > 20)
                return false;

            if ($('#field_1').val().trim().length == 0)
                return false;

            if ($('#field_1').val().trim().length > 20)
                return false;

            if ($('#signup_password').val().trim().length == 0)
                return false;

            if ($('#signup_password_confirm').val().trim().length == 0)
                return false;

            if ($('#signup_password').val() != $('#signup_password_confirm').val())
                return false;

            if (!($('#pass-strength-result').hasClass('strong')))
                return false;

            return true;
        }

        function signup_check_is_valid_action() {
            if (signup_check_is_valid()) {
                $('#signup_submit').removeAttr('disabled');
            } else {
                $('#signup_submit').attr('disabled', true);
            }
        }
    }
    
    if ($('#settings-form')) {
        $('#pass1,#pass2').keydown(function(e) {
            settings_is_valid_keyaction();
        });
        
        $('#pass1,#pass2').keyup(function(e) {
            settings_is_valid_keyaction();
        });
        
        $("#pass1,#pass2").bind("paste", function(e) {
            settings_is_valid_keyaction();
        });
        
        function settings_is_valid() {
            if ($('#pass1').val().trim().length == 0)
                return false;

            if ($('#pass2').val().trim().length == 0)
                return false;

            if ($('#pass1').val() != $('#pass2').val())
                return false;

            if (!($('#pass-strength-result').hasClass('strong')))
                return false;

            return true;
        }

        function settings_is_valid_action() {
            if (settings_is_valid()) {
                $('#settings-form #submit').removeAttr('disabled');
            } else {
                $('#settings-form #submit').attr('disabled', true);
            }
        }
        
        function settings_is_valid_keyaction() {
            if ($('#pass1').val().length > 0) {
                $('#settings-form #submit').attr('disabled', true);
                settings_is_valid_action();
            } else {
                $('#settings-form #submit').removeAttr('disabled');
            }
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
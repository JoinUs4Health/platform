$(document).ready(function(){
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
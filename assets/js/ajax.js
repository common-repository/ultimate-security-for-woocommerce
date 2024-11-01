jQuery(document).ready(function($) {    
    $(document).on('click', '#ultimate_security_for_woocommerce_wooinstall', function(e) {
        // console.log('clicked');
        e.preventDefault();
        var current = $(this);
        var plugin_slug = current.attr("data-plugin-slug");
        current.addClass('updating-message').text('Installing...');
        var data = {
            action: 'ultimate_security_for_woocommerce_ajax_install_plugin',
            _ajax_nonce: ultimate_security_for_woocommerce_ajax_obj.install_plugin_wpnonce,
            slug: plugin_slug,
        };

        $.post(ultimate_security_for_woocommerce_ajax_obj.ajax_url, data, function(response) {
            current.removeClass('updating-message');
            current.addClass('updated-message').text('Installing...');
            current.attr("href", response.data.activateUrl);
        })
        .fail(function() {
            current.removeClass('updating-message').text('Install Failed');
        })
        .always(function() {
            current.removeClass('install-now updated-message').addClass('activate-now button-primary').text('Activating...');
            current.unbind(e);
            current[0].click();
        });
    }); 
    $('body').on('click', '.ultimate-security-for-woocommerce-button-reset', function(reset){
        // console.log('clicked');
        reset.preventDefault();
        let text = "Are You Sure?\nAre you sure you want to proceed with the changes.";
        if (confirm(text) == true) {
            let name= $(this).data('name');
            let url= $(this).data('url');
            if(name) {
                var dataJSON = {
                    action: 'ultimate_security_for_woocommerce_reset_settings',
                    security: ultimate_security_for_woocommerce_ajax_obj.security,
                    name: name,
                };
                $.ajax({
                    cache: false,
                    type: "POST",
                    url: ultimate_security_for_woocommerce_ajax_obj.ajax_url,
                    data: dataJSON,
                    // beforeSend: function() {
                    //     $('.some-class').addClass('loading');
                    // },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            // Simulate a mouse click:
                            // window.location.href = url;

                            // Simulate an HTTP redirect:
                            window.location.replace(url);
                        }
                        // on success
                        // code...
                    },
                    error: function(xhr, status, error) {
                        console.log('Status: ' + xhr.status);
                        console.log('Error: ' + xhr.responseText);
                    },
                    complete: function() {}
                });
            }
        }        
    });
    $("input.search-country-input").keyup(function() {
        let $ths = $(this);
        let userQuery = $(this).val();
        let redirect = $(this).data('redirect');
        let length = userQuery.length;
        // console.log(userQuery);
        // console.log(length);
        if (userQuery.length > 2) {
            var dataJSON = {
                action: 'ultimate_security_for_woocommerce_country_search',
                userQuery: userQuery,
                redirect: redirect,
                security: ultimate_security_for_woocommerce_ajax_obj.security,
            };
            $.ajax({
                cache: false,
                type: "POST",
                url: ultimate_security_for_woocommerce_ajax_obj.ajax_url,
                data: dataJSON,
                // beforeSend: function() {
                //     $('.some-class').addClass('loading');
                // },
                success: function(response) {
                    console.log(response.data.html);
                    if (response.success && response.data.html) {
                        $ths.next('.search-result').html(response.data.html);
                    } else {
                        $ths.next('.search-result').html('');
                    }
                    // on success
                    // code...
                },
                error: function(xhr, status, error) {
                    console.log('Status: ' + xhr.status);
                    console.log('Error: ' + xhr.responseText);
                },
                complete: function() {}
            });
        } else {
            $ths.next('.search-result').html('');
        }
    });
    $('body').on('click', '.ultimate-security-for-woocommerce-change-country', function (e){
        e.preventDefault();
        let code = $(this).data('code');
        let name = $(this).data('name');
        let redirect = $(this).data('redirect');
        var dataJSON = {
            action: 'ultimate_security_for_woocommerce_country_set',
            security: ultimate_security_for_woocommerce_ajax_obj.security,
            name: name,
            code: code,
        };        
        $.ajax({
            cache: false,
            type: "POST",
            url: ultimate_security_for_woocommerce_ajax_obj.ajax_url,
            data: dataJSON,
            // beforeSend: function() {
            //     $('.some-class').addClass('loading');
            // },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    if (redirect) {
                        window.location.href = redirect;
                    } else {
                        window.location.reload(true);
                    }
                    // Simulate a mouse click:
                    // window.location.href = url;

                    // Simulate an HTTP redirect:
                    // window.location.replace(url);
                }
                // on success
                // code...
            },
            error: function(xhr, status, error) {
                console.log('Status: ' + xhr.status);
                console.log('Error: ' + xhr.responseText);
            },
            complete: function() {}
        });
    });
    $('.ultimate-security-for-woocommerce-switch-to-main').find('a').on('click', function (e){
        e.preventDefault();
        let redirect = $(this).data('redirect');
        setCookie('ultimate_security_for_woocommerce_debug_country','',0);
        setCookie('ultimate_security_for_woocommerce_show_notice',1,1);
        window.location.href = redirect;
        // window.location.reload(true);   
        //var url = 'http://example.com/vote/' + Username;
        // var form = $('<form action="' + redirect + '" method="post" style="display: none">' +
        // '<input type="text" name="security" value="' + ultimate_security_for_woocommerce_ajax_obj.security + '" />' +
        // '<input type="text" name="country-change-notice" value="1" />' +
        // '</form>');
        // $('body').append(form);
        // form.submit();     
    });
    $('.ultimate-security-for-woocommerce-switch-notice').find('.notice-dismiss').on('click', function(e){
        $(this).closest('.ultimate-security-for-woocommerce-switch-notice').remove();
        setCookie('ultimate_security_for_woocommerce_show_notice','',0);
    });
    $('#ultimate-security-for-woocommerce-open-switching-dropdown').on('click', function(e){
        e.preventDefault();
        $('#wp-admin-bar-ultimate-security-for-woocommerce-switch-to-country').toggleClass('hover');
    });
    $('.reset-shop-ip').on('click', function(e){
        e.preventDefault();
        let $ths = $(this);
        var dataJSON = {
            action: 'ultimate_security_for_woocommerce_shop_ip_reset',
            security: ultimate_security_for_woocommerce_ajax_obj.security
        };
        // console.log(dataJSON);    
        $.ajax({
            cache: false,
            type: "POST",
            url: ultimate_security_for_woocommerce_ajax_obj.ajax_url,
            data: dataJSON,
            beforeSend: function() {
                $ths.addClass('rotate');
            },
            success: function(response) {
                // console.log(response);
                if (response.success) {
                    $('input.integration-security-for-woocommerce-your-website-ip-address').val(response.data.ultimate_security_for_woocommerce_get_visitor_ip);
                    $('input.integration-security-for-woocommerce-your-website-ip-address').siblings('.form-control-plaintext').html(response.data.ultimate_security_for_woocommerce_get_visitor_ip);
                    
                    $('input.integration-security-for-woocommerce-your-current-location').val(response.data.ultimate_security_for_woocommerce_get_visitor_country_via_api);
                    $('input.integration-security-for-woocommerce-your-current-location').siblings('.form-control-plaintext').html(response.data.ultimate_security_for_woocommerce_get_visitor_country_via_api);

                    $ths.removeClass('rotate');
                }
                // on success
                // code...
            },
            error: function(xhr, status, error) {
                console.log('Status: ' + xhr.status);
                console.log('Error: ' + xhr.responseText);
            },
            complete: function() {}
        });
    });
    $('.reset-shop-country').on('click', function(e){
        e.preventDefault();
        var dataJSON = {
            action: 'ultimate_security_for_woocommerce_shop_country_reset',
            security: ultimate_security_for_woocommerce_ajax_obj.security
        };
        console.log(dataJSON);    
        $.ajax({
            cache: false,
            type: "POST",
            url: ultimate_security_for_woocommerce_ajax_obj.ajax_url,
            data: dataJSON,
            // beforeSend: function() {
            //     $('.some-class').addClass('loading');
            // },
            success: function(response) {
                console.log(response.data.ultimate_security_for_woocommerce_get_visitor_ip);
                if (response.success) {
                }
                // on success
                // code...
            },
            error: function(xhr, status, error) {
                console.log('Status: ' + xhr.status);
                console.log('Error: ' + xhr.responseText);
            },
            complete: function() {}
        });
    });
});
function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
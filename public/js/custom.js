$(function () {
    "use strict";

    // /** add to home screen btn */
    // if ("serviceWorker" in navigator) {
    //     window.addEventListener("load", function () {
    //         navigator.serviceWorker.register("/sw.js").then(
    //             function (registration) {
    //                 // Registration was successful
    //                 console.log(
    //                     "ServiceWorker registration successful with scope: ",
    //                     registration.scope
    //                 );
    //             },
    //             function (err) {
    //                 // registration failed :(
    //                 console.log("ServiceWorker registration failed: ", err);
    //             }
    //         );
    //     });
    // }
    // let deferredPrompt;
    // const addToHomeScreenBtn = document.querySelector(
    //     ".add-to-home-screen-btn"
    // );
    // // console.log(addToHomeScreenBtn);
    // // addToHomeScreenBtn.style.display = "none";
    // window.addEventListener("beforeinstallprompt", (e) => {
    //     // Prevent Chrome 67 and earlier from automatically showing the prompt
    //     e.preventDefault();
    //     // Stash the event so it can be triggered later.
    //     deferredPrompt = e;
    //     // Update UI to notify the user they can add to home screen
    //     // addToHomeScreenBtn.style.display = "block";

    //     if (localStorage.getItem('doNotOfferPWA') == 1) {
    //         return;
    //     }

    //     $('#add-to-home-screen-modal').modal('show');

    //     addToHomeScreenBtn.addEventListener("click", (e) => {
    //         // hide our user interface that shows our A2HS button
    //         // addToHomeScreenBtn.style.display = "none";
    //         $('#add-to-home-screen-modal').modal('hide');

    //         // Show the prompt
    //         deferredPrompt.prompt();
    //         // Wait for the user to respond to the prompt
    //         deferredPrompt.userChoice.then((choiceResult) => {
    //             if (choiceResult.outcome === "accepted") {
    //                 console.log("User accepted the A2HS prompt");
    //             } else {
    //                 console.log("User dismissed the A2HS prompt");
    //             }
    //             deferredPrompt = null;
    //         });
    //     });
    // });
    // $('.dismiss-add-to-home-screen-btn').on('click', function(e){
    //     localStorage.setItem('doNotOfferPWA', 1);
    // });


    /* variables */
    let html = $("html");
    let body = $("body");

    let mousePageX, mousePageY, mouseClientX, mouseClientY;

    /* text to speech, speech synthesis */
    // let synth = window.speechSynthesis;
    // let utter = new SpeechSynthesisUtterance();
    // let speechLanguage = 'ru-RU1';
    // let currentActiveLangRegional = $('[name="active_language_regional"]');
    // if (currentActiveLangRegional.length) {
    //     speechLanguage = currentActiveLangRegional.val().replace('_', '-');
    // }
    // utter.lang = speechLanguage;
    // utter.volume = 0.7;

    /* set csrf token */
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    /* mousemove */
    $(document).on("mousemove", function (e) {
        mousePageX = e.pageX;
        mousePageY = e.pageY;
        mouseClientX = e.clientX;
        mouseClientY = e.clientY;
    });

    /* tooltips */
    // $('[data-toggle="tooltip"]').tooltip();

    // captcha
    refreshCaptcha();

    /* search-form */
    let searchInputTimeout;
    let searchProcessing = false;
    let searchXHR;
    function hideAjaxSearch() {
        $('.ajax-search-results').removeClass('active');
    }
    body.on('click', function(e) {
        if (!$(e.target).closest('.ajax-search-results-content').length && !$(e.target).closest('.ajax-search-input').length) {
            hideAjaxSearch();
        }
    });

    $('.ajax-search-input').on('input focus', function(e){
        let input = $(this);
        if (input.val().length < 3) {
            hideAjaxSearch();
            return;
        }
        clearTimeout(searchInputTimeout);
        searchInputTimeout = setTimeout(() => {
            if (searchProcessing) {
                searchXHR.abort();
            }
            searchProcessing = true;
            let form = input.closest('form');
            let container = $(this).closest('.ajax-search-container');
            let results = container.find('.ajax-search-results')
            let btn = form.find('[type="submit"]');
            let btnHTML = btn.html();
            let sendUrl = form.attr('action');
            let sendData = form.serialize() + '&json=1';
            searchXHR = $.ajax({
                url: sendUrl,
                dataType: "json",
                data: sendData,
                beforeSend: function() {
                    btn.addClass("disabled").prop("disabled", true).html(spinnerHTML());
                }
            })
                .done(function(data) {
                    // console.log(data)
                    results.find('.list-group').empty();
                    if (data.brands.length || data.categories.length || data.products.length) {
                        if (data.brands.length) {
                            for (let i in data.brands) {
                                results.find('.brands-list-group').append('<a href="' + data.brands[i].url + '" class="list-group-item text-gray" title="' + data.brands[i].name + '"><img src="' + data.brands[i].small_img + '" alt="' + data.brands[i].name + '"> ' + data.brands[i].name + '</a>');
                                if (i >= 5) {
                                    break;
                                }
                            }
                        }
                        if (data.categories.length) {
                            for (let i in data.categories) {
                                results.find('.categories-list-group').append('<a href="' + data.categories[i].url + '" class="list-group-item text-gray" title="' + data.categories[i].full_name + '"><img src="' + data.categories[i].small_img + '" alt="' + data.categories[i].full_name + '"> ' + data.categories[i].full_name + '</a>');
                                if (i >= 5) {
                                    break;
                                }
                            }
                        }
                        if (data.products.length) {
                            for (let i in data.products) {
                                results.find('.products-list-group').append('<a href="' + data.products[i].url + '" class="list-group-item text-gray lh-125 d-flex" title="' + data.products[i].name + '"><img src="' + data.products[i].small_img + '" alt="' + data.products[i].name + '"><div><span class="d-inline-block mb-1">' + data.products[i].name + '</span><br><strong>' + data.products[i].current_price_formatted + '</strong></div></a>');
                                if (i >= 5) {
                                    break;
                                }
                            }
                        }
                        // results.append('<a href="' + sendUrl + '?q=' + input.val() + '" class="list-group-item">...</a>');
                        results.addClass('active');

                        // results container position
                        // if ($(window).width() >= 992) {
                        //     if ($('.header-d').hasClass('js-header-scroll')) {
                        //         results.css('top', '78px');
                        //     } else {
                        //         results.css('top', '124px');
                        //     }
                        // }
                    } else {
                        results.find('.list-group').empty();
                        results.removeClass('active');
                    }
                    $(window).scrollTop(0);
                })
                .fail(function(data) {
                    // console.log(data);
                    results.find('.list-group').empty();
                    results.removeClass('active');
                })
                .always(function() {
                    searchProcessing = false;
                    setTimeout(() => {
                        btn.removeClass("disabled").prop("disabled", false).html(btnHTML);
                    }, 100);
                });
        }, 300);
    })

    /* bad eye form */
    let badEyeForm = $(".bad-eye-form");
    $(".btn-bad-eye").on("click", function (e) {
        e.preventDefault();
        let form = $(this).closest("form");
        let group = $(this).closest(".btn-group");
        let param = $(this).data("param");
        let value = $(this).data("value");
        group.find(".btn").removeClass("active");
        $(this).addClass("active");
        form.find("[name=" + param + "]").val(value);
        setTimeout(function () {
            form.submit();
        }, 300);
    });
    $(".set-normal-version").on("click", function (e) {
        e.preventDefault();
        let form = $(".bad-eye-form");
        form.find("input").val("normal");
        form.find(".btn-bad-eye").removeClass("active");
        setTimeout(function () {
            form.submit();
        }, 300);
    });
    badEyeForm.on("submit", function (e) {
        e.preventDefault();
        let form = $(this);
        let sendData = form.serialize();

        // set classes
        let fontSize = form.find("[name=font_size]").val();
        let contrast = form.find("[name=contrast]").val();
        let images = form.find("[name=images]").val();

        html.removeClass(
            "bad-eye-font_size-small bad-eye-font_size-normal bad-eye-font_size-large"
        );
        html.removeClass(
            "bad-eye-contrast-normal bad-eye-contrast-black_white bad-eye-contrast-white_black"
        );
        html.removeClass("bad-eye-images-normal bad-eye-images-disabled");

        if (
            fontSize == "normal" &&
            contrast == "normal" &&
            images == "normal"
        ) {
            html.removeClass("bad-eye");
        } else {
            html.addClass(
                "bad-eye bad-eye-font_size-" +
                    fontSize +
                    " bad-eye-contrast-" +
                    contrast +
                    " bad-eye-images-" +
                    images
            );
        }

        // save params
        $.ajax({
            url: form.attr("action"),
            method: "post",
            data: sendData,
        })
            .done(function (data) {
                // console.log(data);
            })
            .fail(function (data) {
                // console.log(data);
            });
    });
    // init bad-eye-form on start
    // badEyeForm.trigger('submit');
    /* end bad eye form */

    // custom start


    // custom end

    // phone input mask
    // let phoneMaskElements = $(".phone-input-mask");
    // let phoneMaskOptions = {
    //     mask: "+{998}00 000-00-00",
    //     lazy: false,
    // };
    // phoneMaskElements.each(function () {
    //     let element = $(this)[0];
    //     IMask(element, phoneMaskOptions);
    // });

    /* review-form */
    $(".review-form").on("submit", function (e) {
        e.preventDefault();
        let form = $(this);
        let btn = form.find("[type=submit]");
        let message = "";
        let formResultBlock = form.find(".form-result");
        let formHideBlock = form.find(".form-hide-blocks");

        $.ajax({
            method: form.attr("method"),
            url: form.attr("action"),
            dataType: "json",
            data: form.serialize(),
            beforeSend: function () {
                btn.addClass("disabled")
                    .prop("disabled", true)
                    .append(spinnerHTML());
                form.find(".alert").remove();
            },
        })
            .done(function (data) {
                message = `<div class="alert alert-success">
                            ${data.message}
                            </div>`;
                formResultBlock.html(message);
                // form.find('input, textarea').val('');
                formHideBlock.addClass("d-none");
            })
            .fail(function (data) {
                // console.log(data);
                if (data.status == 422) {
                    let result = data.responseJSON;
                    let messageContent = result.message + "<br>";
                    for (let i in result.errors) {
                        messageContent +=
                            "<span>" + result.errors[i] + "</span><br>";
                    }

                    message = `<div class="alert alert-danger">
                            ${messageContent}
                            </div>`;
                    formResultBlock.html(message);
                }
            })
            .always(function (data) {
                setTimeout(function () {
                    btn.removeClass("disabled")
                        .prop("disabled", false)
                        .find(".spinner")
                        .remove();
                }, 1000);
                refreshCaptcha();
            });
    });

    /* contact form */
    $(".contact-form").on("submit", function (e) {
        e.preventDefault();
        let form = $(this);
        let formHideBlock = form.find(".form-hide-blocks");
        let sendUrl = form.attr("action");
        let sendData = form.serialize();
        let button = form.find("[type=submit]");
        let message = "";
        $.ajax({
            url: sendUrl,
            method: "post",
            dataType: "json",
            data: sendData,
            beforeSend: function () {
                // clear message
                form.find(".form-result").empty();
                // disabel send button
                button
                    .addClass("disabled")
                    .prop("disabled", true)
                    .append(spinnerHTML());
            },
        })
            .done(function (data) {
                // console.log(data);
                form.find("input[type=text], input[type=email], textarea").val(
                    ""
                );
                message = `<div class="alert alert-success">
                            ${data.message}
                            </div>`;
                form.find(".form-result").html(message);
                formHideBlock.addClass("d-none");
                if (data.redirect_url) {
                    setTimeout(function () {
                        location.href = data.redirect_url;
                    }, 500);
                }
                // setTimeout(function(){
                //     location.reload();
                // }, 1000);
            })
            .fail(function (data) {
                // console.log(data);
                if (data.status == 422) {
                    let result = data.responseJSON;
                    let messageContent = result.message + "<br>";
                    for (let i in result.errors) {
                        messageContent +=
                            "<span>" + result.errors[i] + "</span><br>";
                    }

                    message = `<div class="alert alert-danger">
                            ${messageContent}
                            </div>`;
                    form.find(".form-result").html(message);
                }
            })
            .always(function () {
                // enable button
                button
                    .removeClass("disabled")
                    .prop("disabled", false)
                    .find(".spinner").remove();
                refreshCaptcha();
            });
    });
    $("#contact-modal").on("show.bs.modal", function (e) {
        let form = $(this).find("form");
        let button = $(e.relatedTarget);
        form.find(
            "[name=product_id], [name=category_id]"
        ).val("");
        if (button.data("product")) {
            form.find("[name=product_id]").val(button.data("product"));
        } else if (button.data("category")) {
            form.find("[name=category_id]").val(button.data("category"));
        }
    });

    /* subscriber form */
    $(".subscriber-form").on("submit", function (e) {
        e.preventDefault();
        let form = $(this);
        let sendUrl = form.attr("action");
        let sendData = form.serialize();
        let button = form.find("[type=submit]");
        let message = "";
        $.ajax({
            url: sendUrl,
            method: "post",
            dataType: "json",
            data: sendData,
            beforeSend: function () {
                // clear message
                form.find(".form-result").empty();
                // disabel send button
                button
                    .addClass("disabled")
                    .prop("disabled", true)
                    .append(spinnerHTML());
            },
        })
            .done(function (data) {
                form.find("input[type=text], input[type=email], textarea").val(
                    ""
                );
                message = `<div class="alert alert-success my-4">
                            ${data.message}
                            </div>`;
                form.find(".form-result").html(message);
            })
            .fail(function (data) {
                console.log(data);
                if (data.status == 422) {
                    let result = data.responseJSON;
                    let messageContent = result.message + "<br>";
                    for (let i in result.errors) {
                        messageContent +=
                            "<span>" + result.errors[i] + "</span><br>";
                    }

                    message = `<div class="alert alert-danger my-4">
                            ${messageContent}
                            </div>`;
                    form.find(".form-result").html(message);
                }
            })
            .always(function () {
                // enable button
                button
                    .removeClass("disabled")
                    .prop("disabled", false)
                    .find(".spinner")
                    .remove();
            });
    });

    // anchor smooth scroll
    //$(document).on('click', 'a[href^="#"]', function (e) {
    $(document).on("click", 'a.anchor[href^="#"]', function (e) {
        e.preventDefault();
        $("html, body").animate(
            {
                scrollTop: $($.attr(this, "href")).offset().top,
            },
            600
        );
    });

    /* theme scripts */

    /* text to speech btn */
    // let textToSpeechBtn = $('.text-to-speech-btn, .text-to-speech-float-btn');
    // body.on('click', '.text-to-speech-btn, .text-to-speech-float-btn', function(e){
    //     e.preventDefault();
    //     if (synth.speaking) {
    //         synth.cancel();
    //         $('.text-to-speech-float-btn').remove();
    //         return;
    //     }
    //     let text = $(this).data('text');
    //     // let selObj = window.getSelection();
    //     // let text = selObj.toString();
    //     if (text) {
    //         utter.text = text;
    //         $(this).find('.fa').addClass('pulsate-fwd');
    //         synth.speak(utter);
    //         utter.onend = function() {
    //             // alert('Speech has finished');
    //             $('.text-to-speech-float-btn').remove();
    //         }
    //     }
    // });

    // let textToSpeechBtnTimeout;
    // document.addEventListener('selectionchange', () => {
    //     clearTimeout(textToSpeechBtnTimeout);
    //     let selObj = window.getSelection();
    //     let text = selObj.toString();
    //     $('.text-to-speech-float-btn').remove();
    //     if (synth.speaking) {
    //         synth.cancel();
    //     }
    //     if (text) {
    //         let currentMouseClientX = mouseClientX;
    //         let currentMouseClientY = mouseClientY;
    //         textToSpeechBtnTimeout = setTimeout(function(){
    //             let btn = '<button class="btn btn-primary btn-round text-to-speech-float-btn" style="position: fixed; left: ' + currentMouseClientX + 'px; top: ' + currentMouseClientY + 'px; z-index: 1000;" data-text="' + text + '"><i class="fa fa-microphone"></i></button>';
    //             $(btn).appendTo(body);
    //         }, 500);
    //     }
    // });
    /* end text to speech btn */

    // // event after text has been spoken
    // utter.onend = function() {
    //     alert('Speech has finished');
    // }
    // // speak
    // synth.speak(utter);

    /* cart */
    // add item to cart
    body.on("click", ".add-to-cart-btn", function (e) {
        e.preventDefault();
        let btn = $(this);
        let btnHTML = btn.html();
        let loader = "add-spinner";
        if (btn.hasClass("only-icon")) {
            loader = "flash-icon";
        }
        if (btn.hasClass("disabled")) {
            if ($(".product_page_in_stock").text() == "0") {
                $("#not-in-stock-modal").modal("show");
            }
            return false;
        }
        let id = btn.attr("data-id");
        let name = btn.attr("data-name");
        let price = btn.attr("data-price");
        let quantity = +btn.attr("data-quantity");
        // console.log(quantity);
        if (quantity < 1) {
            quantity = 1;
        }
        // console.log(quantity);
        if (!id || !name || !price || !quantity) {
            return false;
        }
        $.ajax({
            url: "/cart",
            data: {
                id,
                name,
                price,
                quantity,
            },
            method: "post",
            beforeSend: function () {
                btn.addClass("disabled")
                    .prop("disabled", true);
                if (loader == "flash-icon") {
                    // btn.find('.fa-heart').addClass('pulse');
                    btn.html(spinnerHTML());
                } else {
                    btn.append(spinnerHTML());
                }
            },
        })
            .done(function (data) {
                // console.log(data);

                updateCartInfo(data.cart);
                if (btn.data('checkout-url')) {
                    location.href = btn.data('checkout-url');
                } else {
                    $("#cart-modal").modal("show");
                }
            })
            .fail(function (data) {
                // console.log(data);
            })
            .always(function (data) {
                setTimeout(() => {
                    btn.removeClass("disabled").prop("disabled", false);
                    if (loader == "flash-icon") {
                        btn.html(btnHTML);
                    } else {
                        btn.find(".spinner").remove();
                    }
                }, 500);
            });
    });

    // update cart item
    let updateCartTimeout;
    body.on("change", ".update-cart-quantity-input", function (e) {
        clearTimeout(updateCartTimeout);
        updateCartTimeout = setTimeout(() => {
            let cartContainer = $(".cart_items_container");
            let input = $(this);
            let id = input.attr("data-id");
            let quantity = +input.val();

            if (!id || !quantity) {
                return false;
            }
            $.ajax({
                url: "/cart/update",
                data: {
                    id,
                    quantity,
                },
                method: "post",
                beforeSend: function () {
                    input.addClass("disabled").prop("disabled", true);
                    cartContainer.addClass("disabled");
                },
            })
                .done(function (data) {
                    // console.log(data);
                    updateCartInfo(data.cart);
                    input
                        .closest(".cart_item_line")
                        .find(".product_total")
                        .text(data.lineTotalFormatted);
                    input
                        .closest(".cart_item_line")
                        .find(".product_total_min_price_per_month")
                        .text(data.lineMinPricePerMonthFormatted);
                })
                .fail(function (data) {
                    // console.log(data);
                })
                .always(function (data) {
                    input.removeClass("disabled").prop("disabled", false);
                    cartContainer.removeClass("disabled");
                });
        }, 500);
    });

    // remove cart item
    body.on("click", ".remove-from-cart-btn", function (e) {
        e.preventDefault();
        let btn = $(this);
        if (btn.hasClass("disabled")) {
            return false;
        }
        let url = btn.attr("href");

        $.ajax({
            url: url,
            data: {
                _method: "DELETE",
            },
            method: "post",
            beforeSend: function () {
                btn.addClass("disabled")
                    .prop("disabled", true)
                    .empty()
                    .append(spinnerHTML());
            },
        })
            .done(function (data) {
                // console.log(data);
                btn.closest(".cart_item_line").remove();
                updateCartInfo(data.cart);
            })
            .fail(function (data) {
                // console.log(data);
            })
            .always(function (data) {
                setTimeout(() => {
                    btn.removeClass("disabled")
                        .prop("disabled", false)
                        .find(".spinner")
                        .remove();
                }, 500);
            });
    });

    function updateCartInfo(cart) {
        $(".cart_count").text(cart.quantity);
        $(".cart_total_price").text(cart.totalFormatted);
        $(".cart_min_price_per_month").text(cart.minPricePerMonthFormatted);
        $(".cart_standard_price_total").text(cart.standardPriceTotalFormatted);
        $(".cart_discount_price").text(cart.discountFormatted);
        if (cart.discount > 0) {
            $(".cart_discount_price_container").removeClass('d-none');
        } else {
            $(".cart_discount_price_container").addClass('d-none');
        }
        // toggleCartTotalMessages(cart.total);
    }

    function toggleCartTotalMessages(cartTotal) {
        let checkoutBtns = $(".checkout_btn a");
        let warningMessages = $(".order-amount-too-high-warning");
        let maxTotal =
            warningMessages.attr("data-max") != undefined
                ? +warningMessages.attr("data-max")
                : 50000000;
        if (checkoutBtns.length && warningMessages.length) {
            if (cartTotal > maxTotal) {
                checkoutBtns.addClass("disabled");
                warningMessages.removeClass("d-none");
            } else {
                checkoutBtns.removeClass("disabled");
                warningMessages.addClass("d-none");
            }
        }
    }
    /* end cart */

    /* wishlist */
    // add item to wishlist
    body.on("click", ".add-to-wishlist-btn", function (e) {
        e.preventDefault();
        let btn = $(this);
        if (btn.hasClass("disabled")) {
            return false;
        }
        let btnHTML = btn.html();
        let parentRow = btn.closest(".wishlist-tr-row");
        let url = btn.data("add-url");
        let id = btn.attr("data-id");
        let name = btn.attr("data-name");
        let price = btn.attr("data-price");
        let quantity = 1;
        let loader = "add-spinner";
        if (btn.hasClass("only-icon")) {
            loader = "flash-icon";
        }

        if (!id || !name || !price || !quantity) {
            return false;
        }
        $.ajax({
            url: url,
            data: {
                id,
                name,
                price,
                quantity,
            },
            method: "post",
            beforeSend: function () {
                // disable btn
                btn.addClass("disabled").prop("disabled", true);
                // add loader
                if (loader == "flash-icon") {
                    // btn.find('.fa-heart').addClass('pulse');
                    btn.html(spinnerHTML());
                } else {
                    btn.append(spinnerHTML());
                }
            },
        })
            .done(function (data) {
                updateWishlistInfo(data.wishlist);
                if (parentRow.length) {
                    parentRow.remove();
                } else {
                    btn.removeClass("add-to-wishlist-btn")
                        .addClass("remove-from-wishlist-btn")
                        .addClass("active")
                        .html(btn.attr("data-delete-text"));
                }
            })
            .fail(function (data) {
                console.log(data);
            })
            .always(function (data) {
                setTimeout(() => {
                    // enable btn
                    btn.removeClass("disabled").prop("disabled", false);
                    if (loader == "flash-icon") {
                        btn.html(btnHTML);
                    } else {
                        btn.find(".spinner").remove();
                    }
                }, 200);
            });
    });

    // remove wishlist item
    body.on("click", ".remove-from-wishlist-btn", function (e) {
        e.preventDefault();
        let btn = $(this);
        if (btn.hasClass("disabled")) {
            return false;
        }
        let btnHTML = btn.html();
        let url = btn.data("remove-url");
        let loader = "add-spinner";
        if (btn.hasClass("only-icon")) {
            loader = "flash-icon";
        }

        $.ajax({
            url: url,
            data: {
                _method: "DELETE",
            },
            method: "post",
            beforeSend: function () {
                // disable btn
                btn.addClass("disabled").prop("disabled", true);
                // add loader
                if (loader == "flash-icon") {
                    btn.html(spinnerHTML());
                } else {
                    btn.append(spinnerHTML());
                }
            },
        })
            .done(function (data) {
                // console.log(data);
                btn.closest('.wishlist_item_line').remove();
                updateWishlistInfo(data.wishlist);
                btn.removeClass("remove-from-wishlist-btn")
                    .addClass("add-to-wishlist-btn")
                    .removeClass("active")
                    .html(btn.attr("data-add-text"));
            })
            .fail(function (data) {
                // console.log(data);
            })
            .always(function (data) {
                setTimeout(() => {
                    // enable btn
                    btn.removeClass("disabled").prop("disabled", false);
                    if (loader == "flash-icon") {
                        btn.html(btnHTML);
                    } else {
                        btn.find(".spinner").remove();
                    }
                }, 200);
            });
    });

    function updateWishlistInfo(wishlist) {
        $(".wishlist_count").text(wishlist.quantity);
    }
    /* end wishlist */

    /* compare */
    // add item to compare
    body.on("click", ".add-to-compare-btn", function (e) {
        e.preventDefault();
        let btn = $(this);
        if (btn.hasClass("disabled")) {
            return false;
        }
        let btnHTML = btn.html();
        let url = btn.data("add-url");
        let id = btn.attr("data-id");
        let name = btn.attr("data-name");
        let price = btn.attr("data-price");
        let loader = "add-spinner";
        if (btn.hasClass("only-icon")) {
            loader = "flash-icon";
        }

        if (!id || !name || !price) {
            return false;
        }
        $.ajax({
            url: url,
            data: {
                id,
                name,
                price,
            },
            method: "post",
            beforeSend: function () {
                // disable btn
                btn.addClass("disabled").prop("disabled", true);
                // add loader
                if (loader == "flash-icon") {
                    btn.html(spinnerHTML());
                } else {
                    btn.append(spinnerHTML());
                }
            },
        })
            .done(function (data) {
                // console.log(data);
                updateCompareInfo(data.compare);
                btn.removeClass("add-to-compare-btn")
                    .addClass("remove-from-compare-btn")
                    .addClass("active")
                    .attr("title", btn.data("delete-text"));
            })
            .fail(function (data) {
                console.log(data);
            })
            .always(function (data) {
                setTimeout(() => {
                    // enable btn
                    btn.removeClass("disabled").prop("disabled", false);
                    if (loader == "flash-icon") {
                        btn.html(btnHTML);
                    } else {
                        btn.find(".spinner").remove();
                    }
                    showHideCompareLink(btn, data.compare);
                }, 200);
            });
    });

    // remove compare item
    body.on("click", ".remove-from-compare-btn", function (e) {
        e.preventDefault();
        let btn = $(this);
        if (btn.hasClass("disabled")) {
            return false;
        }
        let btnHTML = btn.html();
        let parentRow = btn.closest(".compare-row");
        let url = btn.data("delete-url");
        let loader = "add-spinner";
        if (btn.hasClass("only-icon")) {
            loader = "flash-icon";
        }

        $.ajax({
            url: url,
            data: {
                _method: "DELETE",
            },
            method: "post",
            beforeSend: function () {
                // disable btn
                btn.addClass("disabled").prop("disabled", true);
                // add loader
                if (loader == "flash-icon") {
                    btn.html(spinnerHTML());
                } else {
                    btn.append(spinnerHTML());
                }
            },
        })
            .done(function (data) {
                // console.log(data);
                if (parentRow.length) {
                    parentRow.remove();
                }
                updateCompareInfo(data.compare);
                btn.removeClass("remove-from-compare-btn")
                    .addClass("add-to-compare-btn")
                    .removeClass("active")
                    .attr("title", btn.data("add-text"));
                $('[data-compare-id="' + btn.data("id") + '"').remove();
            })
            .fail(function (data) {
                // console.log(data);
            })
            .always(function (data) {
                setTimeout(() => {
                    // enable btn
                    btn.removeClass("disabled").prop("disabled", false);
                    if (loader == "flash-icon") {
                        btn.html(btnHTML);
                    } else {
                        btn.find(".spinner").remove();
                    }
                    showHideCompareLink(btn, data.compare);
                }, 200);
            });
    });

    function updateCompareInfo(compare) {
        $(".compare_count").text(compare.quantity);
    }
    function showHideCompareLink(btn, compare) {
        let link = $('.compare-page-link');
        if (!btn || !btn.length || !link.length) {
            return;
        }
        if (compare.quantity < 2) {
            link.removeClass('active');
        } else {
            let {top, left} = btn[0].getBoundingClientRect();
            link.css({top: (top - link.height() - 10) + 'px', left: (left - link.width() / 2 + btn.width() / 2) + 'px'}).addClass('active');
        }
    }
    /* end compare */

    /* input number change */
    $(".input-number-decrement, .input-number-increment").on(
        "click",
        function () {
            let changeValue = $(this).hasClass("input-number-decrement")
                ? -1
                : 1;
            let input = $(this).parent().find(".input-number");
            let newValue = +input.val() + changeValue;
            if (newValue < 1) {
                newValue = 1;
            }
            input.val(newValue);
            input.trigger("change");
        }
    );

    /* choose a region */
    $(".regions-list-group .list-group-item").on("click", function (e) {
        e.preventDefault();
        let btn = $(this);
        let regionID = btn.data("region-id");
        let form = btn.closest("form");
        btn.addClass("disabled").prop("disabled", true).append(spinnerHTML());
        form.find('[name="region_id"]').val(regionID);
        form.trigger("submit");
    });
    $(".confirm-default-region-btn").on("click", function (e) {
        e.preventDefault();
        let btn = $(this);
        let regionID = btn.data("region-id");
        let form = $(".regions-list-form");
        btn.addClass("disabled").prop("disabled", true).html(spinnerHTML());
        form.find('[name="region_id"]').val(regionID);
        form.trigger("submit");
    });
    $(".regions-list-form").on("submit", function (e) {
        e.preventDefault();
        let form = $(this);
        let sendUrl = form.attr("action");
        let sendData = form.serialize();
        let message = "";
        $.ajax({
            url: sendUrl,
            method: "post",
            dataType: "json",
            data: sendData,
            beforeSend: function () {
                form.find(".form-result").empty();
            },
        })
            .done(function (data) {
                message = `<div class="alert alert-success">
                            ${data.message}
                            </div>`;
                form.find(".form-result").html(message);
                $(".regions-list-group").hide();
                setTimeout(function () {
                    location.reload();
                }, 500);
            })
            .fail(function (data) {
                // console.log(data);
                if (data.status == 422) {
                    let result = data.responseJSON;
                    let messageContent = result.message + "<br>";
                    for (let i in result.errors) {
                        messageContent +=
                            "<span>" + result.errors[i] + "</span><br>";
                    }
                    message = `<div class="alert alert-danger">
                            ${messageContent}
                            </div>`;
                    form.find(".form-result").html(message);
                }
            })
            .always(function () {
                // enable button
                form.find(".list-group-item")
                    .removeClass("disabled")
                    .prop("disabled", false)
                    .find(".spinner")
                    .remove();
            });
    });

    let acceptCookie = localStorage.getItem("accept_cookie");
    if (!acceptCookie) {
        $(".accept-cookie").addClass("active");
    }
    $(".accept-cookie-btn").on("click", function (e) {
        e.preventDefault();
        localStorage.setItem("accept_cookie", "1");
        $(".accept-cookie").removeClass("active");
    });
    /* end theme scripts */
}); // ready end

// resize
$(window).on("resize", function () {
    //
});

// load
$(window).on("load", function () {
    //
});

function isScrolledIntoView(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return elemBottom <= docViewBottom && elemTop >= docViewTop;
}

function refreshCaptcha(obj) {
    $(".captcha-container img").each(function () {
        let img = $(this);
        let container = img.closest(".captcha-container");
        // console.log(container);
        $.ajax({
            url: "/captcha/api/flat",
        }).done(function (data) {
            img.attr("src", data.img);
            container.find('[name="captcha_key"]').remove();
            container.append(
                '<input type="hidden" name="captcha_key" value="' +
                    data.key +
                    '">'
            );
        });
    });
}

function spinnerHTML() {
    return `<span class="spinner"><svg class="svg-spinner" width="18" height="18" viewBox="0 0 50 50"><circle class="svg-spinner-path" cx="25" cy="25" r="20" fill="none" stroke-width="5" stroke="currentColor"></circle></svg></span>`;
}

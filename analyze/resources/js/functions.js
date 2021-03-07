'use strict';

/* Pricing plans */
document.querySelector('#plan-monthly') && document.querySelector('#plan-monthly').addEventListener("click", function() {
    document.querySelectorAll('.plan-monthly').forEach(element => element.classList.add('d-block'));
    document.querySelectorAll('.plan-yearly').forEach(element => element.classList.remove('d-block'));
});

document.querySelector('#plan-yearly') && document.querySelector('#plan-yearly').addEventListener("click", function() {
    document.querySelectorAll('.plan-yearly').forEach(element => element.classList.add('d-block'));
    document.querySelectorAll('.plan-monthly').forEach(element => element.classList.remove('d-block', 'plan-preload'));
});

let updateSummary = (type) => {
    if (type == 0) {
        document.querySelectorAll('.checkout-monthly').forEach(function (element) {
            element.classList.add('d-inline-block');
        });

        document.querySelectorAll('.checkout-yearly').forEach(function (element) {
            element.classList.remove('d-inline-block');
        });
    } else {
        document.querySelectorAll('.checkout-monthly').forEach(function (element) {
            element.classList.remove('d-inline-block');
        });

        document.querySelectorAll('.checkout-yearly').forEach(function (element) {
            element.classList.add('d-inline-block');
        });
    }
};

document.querySelector('#current-plan') && document.querySelector('#current-plan').addEventListener('input', function () {
    document.querySelectorAll('.plan-monthly').forEach(element => element.classList.remove('plan-preload'));

    document.querySelectorAll('.plan-toggle').forEach(function (element) {
        element.classList.add('d-none');
    });

    document.querySelectorAll('.plan-toggle' + this.value).forEach(function (element) {
        element.classList.remove('d-none');
    });
});

/* Payment form */
if (document.querySelector('#payment-form')) {
    let radios = document.querySelector('#payment-form').elements["interval"];

    // Event listener for interval changes
    for(var i = 0, max = radios.length; i < max; i++) {
        if (radios[i].checked) {
            updateSummary(radios[i].value);
        }

        radios[i].onchange = function() {
            // Update the URL address
            history.pushState(null, null, this.dataset.periodUrl);

            // Update the form action
            document.querySelector('#payment-form').setAttribute('action', this.dataset.formUrl);

            // Update the Summary
            updateSummary(this.value);
        }
    }
}

document.querySelector('#coupon') && document.querySelector('#coupon').addEventListener('click', function (e) {
    e.preventDefault();

    // Hide the link
    this.classList.add('d-none');

    // Show the coupon input
    document.querySelector('#coupon-input').classList.remove('d-none');

    // Enable the coupon input
    document.querySelector('input[name="coupon"]').removeAttribute('disabled');
});

document.querySelector('#coupon-cancel') && document.querySelector('#coupon-cancel').addEventListener('click', function (e) {
    e.preventDefault();

    document.querySelector('#coupon').classList.remove('d-none');

    // Hide the coupon input
    document.querySelector('#coupon-input').classList.add('d-none');

    // Disable the coupon input
    document.querySelector('input[name="coupon"]').setAttribute('disabled', 'disabled');
});

/* Table Filters */
document.querySelector('#search-filters') && document.querySelector('#search-filters').addEventListener('click', function(e) {
    e.stopPropagation();
});

/* Website */
document.querySelectorAll('input[name="privacy"]').forEach(function (element) {
    element.addEventListener('click', function () {
        if (this.checked && this.value == 2) {
            document.querySelector('#passwordInput').classList.remove('d-none');
            document.querySelector('#passwordInput').classList.add('d-block')
        } else {
            document.querySelector('#passwordInput').classList.add('d-none');
            document.querySelector('#passwordInput').classList.remove('d-block')
        }
    });
});

/* Delete */
document.querySelectorAll('[data-target="#deleteWebsiteModal"]').forEach(function (element) {
    element.addEventListener('click', function () {
        document.querySelector('#deleteWebsiteMessage').textContent = this.dataset.text;
        document.querySelector('#deleteWebsiteModal form').setAttribute('action', this.dataset.action);
    });
});

/**
 * Get the value of a given cookie
 *
 * @param   name
 * @returns {*}
 */
let getCookie = (name) => {
    var name = name + '=';
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');

    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while(c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if(c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
};

/**
 * Set a cookie
 *
 * @param   name
 * @param   value
 * @param   expire
 * @param   path
 */
let setCookie = (name, value, expire, path) => {
    document.cookie = name + "=" + value + ";expires=" + (new Date(expire).toUTCString()) + ";path=" + path;
};

/* General */

// Tooltip
jQuery('[data-enable="tooltip"]').tooltip({animation: true, trigger: 'hover', boundary: 'window'});

// Copy tooltip
jQuery('[data-enable="tooltip-copy"]').tooltip({animation: true});

// Toggle password visibility
window.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-password]').forEach(function (element) {
        element.addEventListener('click', function (e) {
            let passwordInput = document.querySelector('#' + this.dataset.password);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                jQuery(this).tooltip('hide').attr('data-original-title', this.dataset.passwordHide).tooltip('show');
            } else {
                passwordInput.type = 'password';
                jQuery(this).tooltip('hide').attr('data-original-title', this.dataset.passwordShow).tooltip('show');
            }
        });
    });
});

document.querySelectorAll('[data-enable="tooltip-copy"]').forEach(function (element) {
    element.addEventListener('click', function (e) {
        // Update the tooltip
        jQuery(this).tooltip('hide').attr('data-original-title', this.dataset.copied).tooltip('show');
    });

    element.addEventListener('mouseleave', function () {
        this.setAttribute('data-original-title', this.dataset.copy);
    });
});

/* Chart */
Number.prototype.format = function(n, x, s, c) {
    let re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

let commarize = (number, min) => {
    min = min || 1e3;
    // Alter numbers larger than 1k
    if (number >= min) {
        let units = ["K", "M", "B", "T"];
        let order = Math.floor(Math.log(number) / Math.log(1000));
        let unitname = units[order - 1];
        let num = Number((number / 1000 ** order).toFixed(2));
        // output number remainder + unitname
        return num + unitname;
    }
    // return formatted original number
    return number.toLocaleString();
}

/* Slide Menu */
document.querySelectorAll('.slide-menu-toggle').forEach(function(element) {
    element.addEventListener('click', function() {
        document.querySelector('#slide-menu').classList.toggle('active');
    });
});
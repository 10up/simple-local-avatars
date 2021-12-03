/* global ajaxurl, slaAdmin */
(function ($) {
    $(function () {
        function slaAdminAction() {
            const $sla = {
                clearCache: $('#clear_cache_btn'),
            };

            // Spinner button.
            const spinnerButton = '<span class="spinner is-active"></span>';

            // Bind events.
            const bindEvents = function () {
                $sla.clearCache.on('click', function (e) {
                    e.preventDefault();
                    $sla.clearCache.addClass( 'disabled' );
                    var data = {
                        action: 'sla_clear_user_cache',
                        nonce: slaAdmin.nonce,
                    }
                    $sla.clearCache.append(spinnerButton);
                    processStep(1, data, $sla.clearCache);
                });
            };

            /**
             * Process steps.
             *
             * @param {Number} step For batch wise updates.
             * @param {Object} data Data to pass to ajax request.
             * @param {HTMLElement} el Spinner button.
             */
            function processStep(step, data, el) {
                data.step = step;
                $.ajax({
                    url    : ajaxurl,
                    dataType: 'json',
                    data   : data,
                    method : 'POST',
                    success: function (response) {
                        if (response.success) {
                            if (response.data.step === 'done') {
                                el.find('span').remove();
                                $sla.clearCache.removeClass( 'disabled' );
                            } else {
                                processStep(parseInt(response.data.step, 10), data, el);
                            }
                            return false;
                        } else {
                            alert(slaAdmin.error);
                            el.find('span').remove();
                            $sla.clearCache.removeClass( 'disabled' );
                        }
                    },
                    error  : function () {
                        alert(slaAdmin.error);
                        el.find('span').remove();
                        $sla.clearCache.removeClass( 'disabled' );
                    }
                });
            }

            const initializePage = function () {
                bindEvents();
            };

            initializePage();
        }

        // Initialize page.
        slaAdminAction();
    });
})(jQuery); // eslint-disable-line no-undef

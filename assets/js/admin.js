jQuery(document).ready(function ($) {

    /**
     * Anonymize stored IPs
     */
    jQuery( document ).on( 'click', '#gdpr-comments-anonymize-stored-ips', function(e) {

        e.preventDefault();

        var button = $(this);
        var containerSuccessMsg = $('#gdpr-comments-anonymize-stored-ips-result-success');
        var containerErrorMsg = $('#gdpr-comments-anonymize-stored-ips-result-error');

        button.prop('disabled', true);

        // Request
        jQuery.ajax({
            url : gdpr_cc_post.ajax_url,
            type : 'post',
            data : {
                action : 'gdpr_cc_admin_ajax_anonymize_stored_ips_action'
            },
            success : function( response ) {

                console.log('Response: ' + response);

                if ( response ) {
                    console.log('Success');
                    showSuccessMsg();

                } else {
                    console.log('Error');
                    showErrorMsg();
                }

                button.prop('disabled', false);
            }

        });

        function showSuccessMsg() {
            containerErrorMsg.hide();
            containerSuccessMsg.show();
        }

        function showErrorMsg() {
            containerSuccessMsg.hide();
            containerErrorMsg.show();
        }

    });


});
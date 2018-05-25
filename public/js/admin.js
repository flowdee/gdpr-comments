jQuery(document).ready(function(a) {
    jQuery(document).on("click", "#gdpr-comments-anonymize-stored-ips", function(b) {
        function c() {
            g.hide(), f.show();
        }
        function d() {
            f.hide(), g.show();
        }
        b.preventDefault();
        var e = a(this), f = a("#gdpr-comments-anonymize-stored-ips-result-success"), g = a("#gdpr-comments-anonymize-stored-ips-result-error");
        e.prop("disabled", !0), jQuery.ajax({
            url: gdpr_cc_post.ajax_url,
            type: "post",
            data: {
                action: "gdpr_cc_admin_ajax_anonymize_stored_ips_action"
            },
            success: function(a) {
                a ? c() : d(), e.prop("disabled", !1);
            }
        });
    });
});
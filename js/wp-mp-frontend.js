jQuery(document).ready(function($) {

           jQuery('#downloadable').on("click", function() {
       if (this.checked) {
        jQuery('#downloadupload').show();
                         }
       else {
        jQuery('#downloadupload').hide();
                         }
 });

});
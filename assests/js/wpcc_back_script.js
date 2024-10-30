jQuery( document ).ready(function() {
var i= jQuery('#next_wpcc_tab').val();
    var j= parseInt(i)+1;
        jQuery("body").on("click",".add-more",function(){ 
       
        jQuery("#add_more_extra_table").append('<div><p class="form-field wpcc_custom_tab_title_field "><label for="extra_wpcc_title_tab">Custom Tab Title '+j+'</label><input type="text" class="large" name="extra_wpcc_tab_title_fields[]" id="extra_wpcc_title_tab" value="" placeholder=""> </p><p class="form-field wpcc_custom_tab_title_field"><label for="extra_wpcc_desc_tab">Custom Tab Content '+j+'</label><textarea class="short" name="extra_wpcc_tab_desc_fields[]" id="extra_wpcc_desc_tab" placeholder="" rows="2" cols="20" style="width:100%;height:140px;"></textarea></p><br/><a href="javascript:void(0);" class="btn btn-danger removewpcctab">Remove</a></div>');
        i++;
        j++;
    });

    jQuery("body").on("click",".removewpcctab",function(e){ 
        e.preventDefault();
       jQuery(this).parent('div').remove();
    });
});
<?php if (!empty($form_details) AND !$this->input->post()) : ?>    

    <script>
        
        var obj = <?php echo json_encode($form_details); ?>;
        
            for (var key in obj) {
                if (obj.hasOwnProperty(key)) {

                    if ($('[name="'+key+'"]').attr('type') == 'email' || $('[name="'+key+'"]').attr('type') == 'text') {
                        $('#'+key).val(obj[key]);
                    }
                    if ($('[name="'+key+'"]').is('select')) {
                            $('[name="'+key+'"]').find('option').each(function(){
                                if ($(this).val() == obj[key]) {
                                    $(this).attr('selected', 'selected');
                                }
                            });
                    }
                    if ($('[name="'+key+'"]').attr('type') == 'checkbox') {

                        if (obj[key] == null) {
                            $('#'+key).prop('checked', false);
                        } else {
                            $('#'+key).prop('checked', true);
                        }
                    }
                }
            }
                 
    </script>        

    
<?php endif; ?>
$(document).on('ready', function(){
   $(document).on('change', '#disable_carrier', function(){
       if ($('#disable_carrier').prop('checked') == true) {
           $('#CrugeStoredUser_id_carrier').prop('disabled', 'disabled');
           $('#disable_enable').text('Enable');
       } else {
           $('#CrugeStoredUser_id_carrier').prop('disabled', false);
           $('#disable_enable').text('Disable');
       }
   })
});
$(document).ready(function() {
    var current_event = hideChoiceByEvent.current_event;
    var settings = hideChoiceByEvent.settings;

    //go through every field in HideChoiceByEvent variable
    for (field in settings) {
        var field_settings = settings[field];
        for (index in field_settings) {
            var setting = field_settings[index];

            //hide option if we are on the right event
            if(setting.event.indexOf(current_event) != -1) {
                $('#label-' + field + '-' + setting.code).parent().hide(); //standard buttons
                $('[for="opt-' + field + '_' + setting.code + '"]').parent().hide(); //enhanced buttons
            }
        }
    }
});

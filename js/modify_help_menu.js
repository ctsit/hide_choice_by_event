$(document).ready(function() {
    // Checking if field annotation is present on this page.
    if ($('#div_field_annotation').length === 0) {
        return false;
    }

    $('body').on('dialogopen', function(event, ui) {
        var $popup = $(event.target);
        if ($popup.prop('id') !== 'action_tag_explain_popup') {
            // That's not the popup we are looking for...
            return false;
        }

        // Aux function that checks if text matches the "@DEFAULT" string.
        var isDefaultLabelColumn = function() {
            return $(this).text() === '@DEFAULT';
        }

        // Getting @DEFAULT row from action tags help table.
        var $default_action_tag = $popup.find('td').filter(isDefaultLabelColumn).parent();
        if ($default_action_tag.length !== 1) {
            return false;
        }

        var tag_name = '@HIDE-CHOICE-BY-EVENT';
        var descr = 'Hides options for categorical fields based on what event they are on. As input, this tag requires a JSON object that describes when to hide a categorical field. For example: @HIDE-CHOICE-BY-EVENT=[{"code": "1", "event":["demography", "check-up"]}, {"code": "2", "event":["demography"]}] would hide option "1" on the "demography" and "check-up" events. Similarly it would hide option "2" on only the "demography" event. Note that the "code" key corresponds to one of the optional values the categorical field can have, while "event" corresponds to a list of valid events for this project. For more guidence on how to format this JSON check out our <a href="https://github.com/rajputd/hide_choice_by_event" style="font-size:inherit;"><strong>documentation</strong></a>.';

        // Creating a new action tag row.
        var $new_action_tag = $default_action_tag.clone();
        var $cols = $new_action_tag.children('td');
        var $button = $cols.find('button');

        // Column 1: updating button behavior.
        $button.attr('onclick', $button.attr('onclick').replace('@DEFAULT', tag_name));

        // Columns 2: updating action tag label.
        $cols.filter(isDefaultLabelColumn).text(tag_name);

        // Column 3: updating action tag description.
        $cols.last().html(descr);

        // Placing new action tag.
        $new_action_tag.insertAfter($default_action_tag);
    });
});

# hide_choice_by_event
A REDCap module that implements an action tag to hide a categorical field choice on a specified list of events.

## Prerequisites
- [REDCap Modules](https://github.com/vanderbilt/redcap-external-modules)

## Installation
- Clone this repo into to `<redcap-root>/modules/hide_choice_by_event_v<version_number>`.
- Go to **Control Center > Manage External Modules** and enable Hide Choice By Event.
- For each project you want to use this module, go to the project home page, click on **Manage External Modules** link, and then enable the Hide Choice By Event module for that project.

## How to use
Once the module is activated on a project, the @HIDE-CHOICE-BY-EVENT tag will be available in the action tag help text of the Online Designer. Add @HIDE-CHOICE-BY-EVENT to any categorical field where you would like to hide some of the choices based on the event.

As an argument you will need to provide a JSON object that tells the tag which choice to hide on which event. It should look something like this:
```
@HIDE-CHOICE-BY-EVENT = [
    {
        "code":"1",
        "event": ["enrollment_1_arm_1", "dose_1_arm_1"]
    },
    {
        "code":"3",
        "event": ["dose_1_arm_1"]
    }
]
```
Note that the whitespace in the above example is unnecessary. This example would hide option "1" on the "enrollment_1_arm_1" and "dose_1_arm_1" events. Similarly, it would also hide option "3" on the  "dose_1_arm_1" event. As can be seen "code" signifies which field option to hide. "event" indicates for which events this option should be hidden.

To find a list of unique event names to use for the "event" field go to **Project Setup > Define My Events**. The right-most column will contain a list of unique event names.

## Limitations

Currently this module only supports radio buttons. It will not hide the choices for any other type of field.

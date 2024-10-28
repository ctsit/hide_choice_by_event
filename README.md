# Hide Choice by Event

[![DOI](https://zenodo.org/badge/139999906.svg)](https://doi.org/10.5281/zenodo.14004245)

A REDCap module that implements an action tag to hide a categorical field choice on a specified list of events.

## Prerequisites
- REDCap >= 14.0.2
- PHP >= 7.4

## Easy Installation
- Obtain this module from the Consortium [REDCap Repo](https://redcap.vanderbilt.edu/consortium/modules/index.php) from the Control Center.

## Manual Installation
- Clone this repo into `<redcap-root>/modules/hide_choice_by_event_v<version_number>`.
- Go to **Control Center > Manage External Modules** and enable Hide Choice by Event.

## How to use
Go to your project home page, click on Manage External Modules link, and then enable Hide Choice by Event.

Once the module is activated on a project, the `@HIDE-CHOICE-BY-EVENT` tag will be available in the action tag help text of the Online Designer. Add `@HIDE-CHOICE-BY-EVENT` to any categorical field where you would like to hide some of the choices based on the event.

As an argument you will need to provide a JSON object that tells the tag which choice to hide on which event. It should look something like this:
```json
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

See [HideChoiceByEventTest.REDCap.xml](examples/HideChoiceByEventTest.REDCap.xml) for an example of _Hide Choice by Event_ in a longitudinal, 2-arm project.

## Limitations

This module currently supports only radio buttons, checkboxes, and their enhanced versions. It will not hide choices for any other field types.

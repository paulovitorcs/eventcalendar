# eventcalendar
This is a Eventcalendar plugin to Wordpress, to Lottaleben challenge.

To this plugin is essencial to install bower and composer components. It depends on the libraries Metabox.io and FullCalendar. Metabox.io is a Wordpress Library to register custom fields. FullCalendar is an Javascript Library to EventCalendars, customizable and open-source that provides nice and usefull calendars with jQuery.

I solved the recurrence chalenge, creating just one event on Wordpress Admin Area, but allowing it to repeat on the calendar. To do that, I've created a new rule do set a limit date to recurrence. By default, it's set on 2050, but it can be changed in any moment on the admin area when creating, or updating an event. So, the FullCalendar receives the event and recreate then multiple times, by only changing the date but still redirecting it to the "original" event single page. 

I choose to display the overview archive throw the Wordpress tool shortcode. With that, it will be easy to show the calendar in a post, a page or even in a widget.

Any doubts, get in contact with me by paulocsvitor@gmail.com

<div class="row">
	<div class="col-sm-4 col-sm-offset-6">
		<a href="#addEntry" class="btn btn-primary" data-toggle="modal">Add Event</a>
	</div>
</div>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<div id='calendarDiv'></div>
	</div>
</div>
<div class="modal fade" id="addEntry">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title">Add Event</h4>
      		</div>
            <form class="form" role="form" id="eventForm" method="post" action="entries/create">
      		<div class="modal-body">
        			<div class="form-group">
        				<label for="category">Event Name</label>
        				<input type="text" name="title" class="form-control" />
        			</div>
                    <div class="form-group">
                        <label for="start_date">Event Start Date</label>
                        <div class="input-group date" id="start_date">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input data-format="yyyy-MM-dd" type='text' name="start_date" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
			            <label>Event End Date</label>
			            <div class="input-group addon" id="end_date">
			                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
			                <input data-format="yyyy-MM-dd" type="text" class="form-control" name="end_date" />
			            </div>
			        </div>
        			<div class="form-group">
                        <label for="description">Event Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		<input type="Submit" class="btn btn-primary" value="Add Event" />
      		</div>
            </form>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendarDiv').fullCalendar({
        // put your options and callbacks here
        events: function(start, end, callback) {
	        $.ajax({
	            url: '<?php echo URL::to("/calendar/entries/events"); ?>',
	            dataType: 'json',
	            data: {
	                // our hypothetical feed requires UNIX timestamps
	                start: Math.round(start.getTime() / 1000),
	                end: Math.round(end.getTime() / 1000)
	            },
	            success: function(doc) {
	            	console.log(doc);
	                var events = [];
	                for (i in doc) {
	                	
	                    events.push({
	                    	id: doc[i].id,
	                        title: doc[i].title,
	                        description: doc[i].description,
	                        start: doc[i].start_date,
	                        end: doc[i].end_date

	                    });
	                };
	                callback(events);
	            }
	        });
	    },
	    editable: true,
	    eventColor: '#2C2C2C',
	    eventMouseover: function( event, jsEvent, view ) { 
	    	//console.log(this);
	    	$(this).attr('title', event.description);
	    	$(this).tooltip({
		      position: {
		        my: "center bottom-20",
		        at: "center top",
		        using: function( position, feedback ) {
		          $( this ).css( position );
		          $( "<div>" )
		            .addClass( "arrow" )
		            .addClass( feedback.vertical )
		            .addClass( feedback.horizontal )
		            .appendTo( this );
		        }
		      }
		    });
		    $(this).tooltip('show');
	    },
	    eventClick: function(event, jsEvent, view) {
	    	
	    	//$.post('<?php echo URL::to("/calendar/entries/destroy"); ?>', {id: event.id});
	    },
	    eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
	    	var start_date = new Date(event.start);
	    	var end_date = new Date(event.end);
	        
	        var eventArr = {
	        	id: event.id,
	        	start_date: formatDate(start_date),
	        	end_date: formatDate(end_date)
	        }
	        $.post('<?php echo URL::to("/calendar/entries/update"); ?>', eventArr);
	        //cal.update(eventArr);
	        
    	},
    	eventResize: function(event) {
    		console.log(event);
    		var start_date = new Date(event.start);
	    	var end_date = new Date(event.end);
	        
	        var eventArr = {
	        	id: event.id,
	        	start_date: formatDate(start_date),
	        	end_date: formatDate(end_date)
	        }
	        console.log(eventArr);
	        $.post('<?php echo URL::to("/calendar/entries/update"); ?>', eventArr);
    	}
    })


    $('#start_date').datetimepicker({
	    pickTime: false,
	});
	$('#end_date').datetimepicker({
		pickTime: false,
	});
});

function formatDate(date) {
	var year = date.getFullYear();
	var month = date.getMonth() + 1;
	var day = date.getDate();

	return year + '-' + month + '-' + day;
}
</script>
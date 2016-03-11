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
        				<label for="category">Event for</label>
        				<input type="text" name="for" class="form-control" />
        			</div>
                    <div class="form-group">
                        <label for="start_date">Event Start Date</label>
                        <div class="input-group date" id="start_date">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input data-format="yyyy-MM-dd" type='text' name="start_date" class="form-control form-dateTime" />
                        </div>
                    </div>
                    <div class="form-group">
			            <label>Event End Date</label>
			            <div class="input-group addon" id="end_date">
			                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
			                <input data-format="yyyy-MM-dd" type="text" class="form-control form-dateTime" name="end_date" />
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


<div class="modal fade" id="editEntry">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title">Edit Event</h4>
      		</div>
            <form class="form" role="form" id="eventForm" method="post" action="entries/update">
      		<div class="modal-body">
        			<div class="form-group">
        				<label for="category">Event Name</label>
        				<input type="text" id="title" name="title" class="form-control" />
        			</div>
					<div class="form-group">
        				<label for="category">Event for</label>
        				<input type="text" id="for" name="created_for" class="form-control" />
        			</div>
					<div class="form-group">
        				<label for="category">Event Brought to you by</label>
        				<input type="text" id="by" name="created_by" class="form-control" disabled />
        			</div>
					<div class="form-group">
        				<label for="category">Last Updated By: </label>
        				<input type="text" id="updated_by" name="updated_by" class="form-control" disabled />
        			</div>
                    <div class="form-group">
                        <label for="start_date">Event Start Date</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input data-format="yyyy-MM-dd" id="start" type='text' name="start_date" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
			            <label>Event End Date</label>
			            <div class="input-group addon" >
			                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
			                <input data-format="yyyy-MM-dd" id="end" type="text" class="form-control" name="end_date" />
			            </div>
			        </div>
        			<div class="form-group">
                        <label for="description">Event Description</label>
                        <textarea id="description" name="description" class="form-control"></textarea>
						<input type="hidden" id="id" name="id" value="0"/>
                    </div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		<input type="Submit" class="btn btn-primary" value="Save Event" />
				</br></br>
				<button type="button" class="btn red-primary" onclick="deleteEvent(this.id)">Delete Event</button>
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
						//console.log(doc[i].start_date);
						//console.log(doc[i].end_date);
						//console.log('');
	                    events.push({
	                    	id: doc[i].id,
	                        title: doc[i].title,
	                        description: doc[i].description,
	                        start: doc[i].start_date,
	                        end: doc[i].end_date,
							updated_by: doc[i].last_updated_by,
							created_by: doc[i].created_by,
							created_for: doc[i].created_for,
							allDay: false
	                    });
						console.log(events[i].updated_by + " : " + doc[i].last_updated_by);
	                };
	                callback(events);
	            }
	        });
	    },
		timeFormat:'h(:mm)t { - h(:mm)t}',
	    editable: true,
	    eventColor: '#2C2C2C',
	    eventMouseover: function( event, jsEvent, view ) { 
	    	//console.log(this);
	    	$(this).attr('title', event.description);
	    	$(this).tooltip({
		      position: {
				 //Will give you another tooltip if this is here. 2 in total
		        //my: "center bottom-20",
		        at: "center top",
		        /*using: function( position, feedback ) {
		          $( this ).css( position );
		          $( "<div>" )
		            .addClass( "arrow" )
		            .addClass( feedback.vertical )
		            .addClass( feedback.horizontal )
		            .appendTo( this );
		        }*/
		      }
		    });
		    $(this).tooltip('show');
	    },
	    eventClick: function(event, jsEvent, view) {
			//jQuery.noConflict();
			$("#editEntry").modal('show');
			document.getElementById('title').value = event.title;
			document.getElementById('id').value = event.id;
			document.getElementById('updated_by').value = event.updated_by;
			//document.getElementById('start').value = event.start;
			//document.getElementById('end').value = event.end;
			
			$("#start").datetimepicker({
				value: event.start, 
				format: 'Y/m/d H:i'
			});
			
			$("#end").datetimepicker({
				value: event.end, 
				format: 'Y/m/d H:i'
			});
			

			document.getElementById('start').value = getDateString(event.start);
			
			document.getElementById('end').value = getDateString(event.end);
			
			document.getElementById('for').value = event.created_for;
			document.getElementById('by').value = event.created_by;
			document.getElementById('description').value = event.description;
			//$(".form-dateTime").datetimepicker();

	    	//$.post('<?php echo URL::to("/calendar/entries/destroy"); ?>', {id: event.id, created_by: event.created_by});
	    },
	    eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
			
			document.getElementById('jsid').value = event.id;
			document.getElementById('jsfor').value = event.created_for;
			document.getElementById('jsstart').value = getDateString(event.start);
			document.getElementById('jsend').value = getDateString(event.end);
			//document.getElementById('jscreated_by').value = document.getElementById('by').value;
			document.getElementById('jsEventForm').action = '/calendar/entries/update';
			document.forms['jsEventForm'].submit();
			
			//console.log(start_date.toLocaleString()); close
	   
			
			/*$.ajax({
				type: 'POST',
				url: '/calendar/entries/update',
				data: {
						id: event.id,
						start_date: getDateString(event.start),
						end_date: getDateString(event.end),
						created_for: event.created_for
					  },
				success: function(data)
				{
					//alert(data.message);
				},
				error: function(data){
					//alert(data.responseJSON.message);
					//window.location.reload();
				}
			});*/
			
	        //var eventArr = {
	        	//id: event.id,
	        	//start_date: formatDate(start_date),
	        	//end_date: formatDate(end_date),
				//created_by: event.created_by,
				//created_for: event.created_for
	       //}
	        //var info = $.post('<?php echo URL::to("/calendar/entries/update"); ?>', eventArr);
			//console.log(info);
	        //cal.update(eventArr);
	        
    	},
    	eventResize: function(event) {
    		
			document.getElementById('jsid').value = event.id;
			document.getElementById('jsfor').value = event.created_for;
			document.getElementById('jsstart').value = getDateString(event.start);
			document.getElementById('jsend').value = getDateString(event.end);
			//document.getElementById('jscreated_by').value = document.getElementById('by').value;
			document.getElementById('jsEventForm').action = '/calendar/entries/update';
			document.forms['jsEventForm'].submit();
	        
	        /*var eventArr = {
	        	id: event.id,
	        	start_date: formatDate(start_date),
	        	end_date: formatDate(end_date)
	        }*/
			//console.log(eventArr);
	        //$.post('<?php echo URL::to("/calendar/entries/update"); ?>', eventArr);
    	}
    })


    /* Does duplicates. Do not keep.
	$('#start_date').datetimepicker({
	    pickTime: false,
	});
	$('#end_date').datetimepicker({
		pickTime: false,
	});
	*/
});
$(document).ready(function(){
	$(".form-dateTime").datetimepicker({
					});
});


function formatDate(date) {
	var year = date.getFullYear();
	var month = date.getMonth() + 1;
	var day = date.getDate();

	return year + '-' + month + '-' + day;
}

function deleteEvent(id){
	
	if(confirm('Are you sure you want to delete this event?')){
		
		
		document.getElementById('jsid').value = document.getElementById('id').value;
		document.getElementById('jscreated_by').value = document.getElementById('by').value;
		$("#editEntry").modal('hide');
		document.forms['jsEventForm'].submit();

		/*$.ajax({			//ajax code here fo future reference
			type: 'POST',
			url: '/calendar/entries/destroy',
			data: {
				id: document.getElementById('id').value
			},
			success: function(data)
			{
				//alert(data.message);
				//window.location.reload();
			},
			error: function(data){
				//alert(data.responseJSON.message);
			}
		});*/
	}
	
}

function getMonth(month){
	switch(month){
	case 'Jan': return '01';
	case 'Feb': return '02';
	case 'Mar': return '03';
	case 'Apr': return '04';
	case 'May': return '05';
	case 'Jun': return '06';
	case 'Jul': return '07';
	case 'Aug': return '08';
	case 'Sep': return '09';
	case 'Oct': return '10';
	case 'Nov': return '11';
	case 'Dec': return '12';
	}
}

// Converts Date to proper format.  Date {Thu Mar 03 2016 14:39:00 GMT-0500 (Eastern Daylight Time)} to 2016/03/03 14:39
function getDateString(date){
	var pattern = new RegExp("([A-za-z]{3}) ([0-9]{2}) ([0-9]{4}) ([0-9]{2}:[0-9]{2})","");
	var m;
	if((m = pattern.exec(date)) !== null){
			
		m[1] = getMonth(m[1]);
			
		var dateString = m[3] + "/" + m[1]+ "/" + m[2] + " " + m[4];
		//console.log("The date is:  " + dateString);
	}
	return dateString
}
</script>

<!-- Used to send data from Javascript to php -->
<div class="modal fade" id="jsEntry">
  	<div class="modal-dialog">
    	<div class="modal-content">
            <form class="form" role="form" id="jsEventForm" method="post" action="entries/destroy">
      		<div class="modal-body">

        		<input type="text" id="jstitle" name="title" class="form-control" value=""/>

        		<input type="text" id="jsfor" name="created_for" class="form-control" value=""/>

                <input data-format="yyyy-MM-dd" id="jsstart" type='text' name="start_date" value=""/>

				<input data-format="yyyy-MM-dd" id="jsend" type="text" name="end_date" value=""/>

				<input type="text" id="jscreated_by" name="created_by" value=""/>
                <input type="hidden" id="jsid" name="id" value=""/>

      		</div>
            </form>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
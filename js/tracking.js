/// Calculate the clicks on all the links and return it as a form object
/// 

var page_clicks = {};

$('.tracked_link').click(function(){

    var href = this.href;

    if(page_clicks[ href ] === undefined){
      page_clicks[ "" + href ] = 1; 
    } else {
      page_clicks[ "" + href ] += 1; 
    }

    console.log( page_clicks );
});

/// Track the mouse movements of the page
/// 

var histo = [];

function handleMouseMove(event) {

  var dot, eventDoc, doc, body, pageX, pageY;

  event = event || window.event; // IE-ism

  // If pageX/Y aren't available and clientX/Y are,
  // calculate pageX/Y - logic taken from jQuery.
  // (This is to support old IE)
  if (event.pageX == null && event.clientX != null) {
    eventDoc = (event.target && event.target.ownerDocument) || document;
    doc = eventDoc.documentElement;
    body = eventDoc.body;

    event.pageX = event.clientX +
    (doc && doc.scrollLeft || body && body.scrollLeft || 0) -
    (doc && doc.clientLeft || body && body.clientLeft || 0);
    event.pageY = event.clientY +
    (doc && doc.scrollTop || body && body.scrollTop || 0) -
    (doc && doc.clientTop || body && body.clientTop || 0);
    }

  var point = {

  x: event.pageX,
  y: event.pageY,
  val: 499
  
  };

  histo.push(point)

}


/// appending to form functions
/// 

function add_to_form( formId, name, data ) {

  $('<input />').attr('type', 'hidden')
  .attr('name', name)
  .attr('value', data)
  .appendTo( formId );

}

function add_links_to_form( formId, links ) {

  for (var key in links) {
    if (links.hasOwnProperty(key)) {

      $('<input />').attr('type', 'hidden')
                    .attr('name', 'links[' + key + ']')
                    .attr('value', links[key])
                    .appendTo( formId );
    }
  }

}

/// Submit the resume to the form
/// 

$( "#resume_submit" ).click(function() {

    //find ammount of time spent on page
    var timeSpentOnPage = TimeMe.getTimeOnCurrentPageInSeconds();

    add_to_form('#resume_form', 'histo', JSON.stringify(histo));
    add_to_form('#resume_form', 'time_spent', timeSpentOnPage);
    add_links_to_form('#resume_form', page_clicks);



   console.log($('#resume_form').serialize());
   $("#resume_form").submit();

});
   
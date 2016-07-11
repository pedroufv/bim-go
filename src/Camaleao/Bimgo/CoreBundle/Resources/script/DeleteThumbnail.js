// dependencies
var AWS = require('aws-sdk');
var util = require('util');

// get reference to S3 client 
var s3 = new AWS.S3();
 
exports.handler = function(event, context) {
	// Read options from the event.
	console.log("Reading options from event:\n", util.inspect(event, {depth: 5}));
	var srcBucket = event.Records[0].s3.bucket.name;
	var srcKey    = event.Records[0].s3.object.key;
	var dstBucket = srcBucket + "-thumbnails";
	var dstKey    = "thumb-" + srcKey;

	// Sanity check: validate that source and destination are different buckets.
	if (srcBucket == dstBucket) {
		console.error("Destination bucket must not match source bucket.");
		return;
	}

	// Infer the image type.
	var typeMatch = srcKey.match(/\.([^.]*)$/);
	if (!typeMatch) {
		console.error('unable to infer image type for key ' + srcKey);
		return;
	}
	var imageType = typeMatch[1];
	if (imageType != "jpg" && imageType != "png") {
		console.log('skipping non-image ' + srcKey);
		return;
	}

	var params = {
	  Bucket: dstBucket, /* required */
	  Delete: { /* required */
	    Objects: [ /* required */
	      {
		Key: dstKey
	      },
	    ],
	  },
	};
	
	// Delete the image from S3 bucket.
	s3.deleteObjects(params, function(err, data) {
	  if (err) console.log(err, err.stack); // an error occurred
	  else     console.log(data);           // successful response
	});
};

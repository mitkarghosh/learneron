var stepped = 0, chunks = 0, rows = 0;
var start, end;
var parser;
var pauseChecked = false;
var printStepChecked = true;
var hasHeader = false;

$(function()
{
	$('#submit-parse').click(function()
	{
		stepped = true;
		chunks = 0;
		rows = 0;
		var txt = '';
		var localChunkSize = '';
		var remoteChunkSize = '';
		var files = $('#files')[0].files;
		/*if($('#totalUpload').length){
			hasHeader = true;
		}else{
			hasHeader = false;
		}*/
		var config = buildConfig();
		//Papa.SCRIPT_PATH = 'http://192.168.1.109/holiday_hagglers/admin/js/papa_parse_custom.js';

		// NOTE: Chunk size does not get reset if changed and then set back to empty/default value
		if (localChunkSize)
			Papa.LocalChunkSize = localChunkSize;
		if (remoteChunkSize)
			Papa.RemoteChunkSize = remoteChunkSize;

		pauseChecked = '';
		printStepChecked = true;


		if (files.length > 0)
		{
			//if (!$('#stream').prop('checked') && !$('#chunk').prop('checked'))
			if (false)
			{
				for (var i = 0; i < files.length; i++)
				{
					if (files[i].size > 1024 * 1024 * 10)
					{
						alert("A file you've selected is larger than 10 MB; please choose to stream or chunk the input to prevent the browser from crashing.");
						return;
					}
				}
			}

			start = performance.now();
			
			$('#files').parse({
				config: config,
				before: function(file, inputElem)
				{
					console.log("Parsing file:", file);
				},
				complete: function()
				{
					console.log("Done with all files.");
				}
			});
		}
		else
		{
			start = performance.now();
			var results = Papa.parse(txt, config);
			console.log("Synchronous parse results:", results);
		}
	});

	$('#submit-unparse').click(function()
	{
		var input = $('#input').val();
		var delim = $('#delimiter').val();

		var results = Papa.unparse(input, {
			delimiter: delim
		});

		console.log("Unparse complete!");
		console.log("--------------------------------------");
		console.log(results);
		console.log("--------------------------------------");
	});

	$('#insert-tab').click(function()
	{
		$('#delimiter').val('\t');
	});
});



function buildConfig()
{

	return {
		delimiter: '',
		newline: getLineEnding(),
		header: hasHeader,
		dynamicTyping: false,
		preview: '',
		step: true ? stepFn : undefined,
		encoding: '',
		worker: false,
		comments: '',
		complete: completeFn,
		error: errorFn,
		download: false,
		fastMode: false,
		skipEmptyLines: true,
		chunk: false ? chunkFn : undefined,
		beforeFirstChunk: undefined,
	};

	function getLineEnding()
	{
		return "";
	}
}
var i = 0, a = 0;
function stepFn(results, parserHandle)
{
	stepped++;
	i++;
	a++;
	rows += results.data.length;

	parser = parserHandle;
	
	if (pauseChecked)
	{
		console.log(results, results.data[0]);
		parserHandle.pause();
		return;
	}
	
	if (printStepChecked){
		csvData.push(results.data[0]);
		if($('#totalUpload').length == 0){
			var totalUpload = 1000;
		}else{
			var totalUpload = $('#totalUpload').val();
		}
		if(i == totalUpload){
			//console.log(csvData.length);
			parserHandle.pause();
			/*console.log(a);
			console.log(results.data[0]);
			console.log(csvData);*/
			var status = uploadExcel(csvData,parserHandle,totalUpload,a,1);
			csvData = [];
			/*setTimeout(function() {
				csvData = [];
				parserHandle.resume();
			}, 5000);*/
			i = 0;
			return;
		}
	}
		//console.log(results, results.data[0]);
}

function chunkFn(results, streamer, file)
{
	if (!results)
		return;
	chunks++;
	rows += results.data.length;

	parser = streamer;

	if (printStepChecked)
		console.log("Chunk data:", results.data.length, results);

	if (pauseChecked)
	{
		console.log("Pausing; " + results.data.length + " rows in chunk; file:", file);
		streamer.pause();
		return;
	}
}

function errorFn(error, file)
{
	console.log("ERROR:", error, file);
}

function completeFn()
{
	end = performance.now();
	if (!$('#stream').prop('checked')
			&& !$('#chunk').prop('checked')
			&& arguments[0]
			&& arguments[0].data)
		rows = arguments[0].data.length;
	showCsvData();
	uploadExcel(csvData,'',500,a);
	console.log("Finished input (async). Time:", end-start, arguments);
	console.log("Rows:", rows, "Stepped:", stepped, "Chunks:", chunks);
}
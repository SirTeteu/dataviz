import axios from 'axios';
// const axios = require("axios");

export const API_PATH = "http://localhost/api"

function core(args) {

	axios({
		url: args.url,
		method: args.method,
		data: args.data,
		params: args.params,
	})
	.then(response => {
		if (args.success) {
			console.log(args.method + " - " + args.url);
			console.log(args);
            console.log(response);

            args.success(response.data)
		}

	})
	.catch(e => {
		console.log(args.method + " - " + args.url);
		console.log(e.response);

		if (args.error) {
            let decodedString = String.fromCharCode.apply(null, new Uint8Array(e.response.data));
            let obj = JSON.parse(decodedString);
        
            args.error({ msg: obj.error.msg});

            return;
		}
	})
}

export function get(args) {
	args.method = 'get';
	core(args);
}
import { API_PATH, get } from "./api.js";

export default  {

    get: function(args) {
        get({
            url: `${API_PATH}/estados`,
            ...args
        })
    },
}
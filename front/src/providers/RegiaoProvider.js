import { API_PATH, get } from "./api.js";

export default  {

    getEstados: function(args) {
        get({
            url: `${API_PATH}/regiao/estados`,
            ...args
        })
    },
}
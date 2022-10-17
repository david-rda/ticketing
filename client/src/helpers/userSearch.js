import axios from "axios";

async function userSearch(token, fullname) {
    if(fullname.trim() == "" || fullname.trim() == null || fullname.length === 0) {
        return false;
    }else {
        const users = await axios.post("http://172.16.30.19/ticketing/server/public/api/user/search", {
            fullname : fullname
        }, {
            headers : {
                "Authorization" : `Bearer ${token}`
            }
        });

        return users;
    }
}

export default userSearch;
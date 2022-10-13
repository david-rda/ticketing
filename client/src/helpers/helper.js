import axios from "axios";

async function load_tasks(token) {
    const data = await axios.get("http://172.16.30.19/ticketing/server/public/api/task/list", {
        headers : {
            "Authorization" : `Bearer ${token}`
        }
    });

    return data;
}

async function tasks_by_status(token, status_id) {
    const data = await axios.get("http://172.16.30.19/ticketing/server/public/api/task/by/status/" + status_id, {
        headers : {
            "Authorization" : `Bearer ${token}`
        }
    });

    return data;
}

export { load_tasks, tasks_by_status }
export const sendRequest = async (url, token, data) => {
    return await fetch(`localhost:8000/api/${url}`, {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'x-auth-token': token,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
}
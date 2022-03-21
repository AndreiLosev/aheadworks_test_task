export const sendRequest = async (url, data, token) => {
    return await fetch(`http://localhost:8000/api/${url}`, {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'x-auth-token': token,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
}
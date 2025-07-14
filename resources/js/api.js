const API_BASE = '/api';
async function refreshToken() {
  const expiredToken = localStorage.getItem('token');
  if (!expiredToken) throw new Error("No token to refresh");

  const res = await fetch(`${API_BASE}/refresh`, {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${expiredToken}`,
      Accept: 'application/json'
    }
  });

  if (!res.ok) throw new Error("Refresh failed");

  const data = await res.json();
  const newToken = data.authorisation.token;
  localStorage.setItem('token', newToken);
  return newToken;
}

export async function apiFetch(endpoint, options = {}, retry = true) {
  let token = localStorage.getItem('token');

  const headers = {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    ...(token ? { Authorization: `Bearer ${token}` } : {}),
    ...(options.headers || {})
  };

  let res = await fetch(`${API_BASE}${endpoint}`, {
    ...options,
    headers,
  });

  if (res.status === 401 && retry) {
    try {
      const newToken = await refreshToken();
      const retryHeaders = {
        ...headers,
        Authorization: `Bearer ${newToken}`
      };
      res = await fetch(`${API_BASE}${endpoint}`, {
        ...options,
        headers: retryHeaders
      });
    } catch (err) {
      localStorage.removeItem('token');
      window.location.href = '/login';
    }
  }

  return res;
}

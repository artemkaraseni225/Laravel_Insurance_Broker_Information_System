import api from './api';

export async function register(payload) {
  const { data } = await api.post('/register', payload);
  return data;
}

export async function login(payload) {
  const { data } = await api.post('/login', payload);
  return data;
}

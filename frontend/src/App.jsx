import { Routes, Route } from 'react-router-dom';
import Login from './pages/Login';
import Register from './pages/Register';

function Home() {
  return (
    <div className="flex min-h-screen items-center justify-center">
      <p className="text-lg text-muted-foreground">
        Главная страница — появится в следующих шагах.
      </p>
    </div>
  );
}

function App() {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />
      <Route path="/" element={<Home />} />
    </Routes>
  );
}

export default App;

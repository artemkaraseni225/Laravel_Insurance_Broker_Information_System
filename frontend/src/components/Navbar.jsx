import { Link, NavLink, useNavigate } from 'react-router-dom';
import api from '../services/api';

const navLinkClass = ({ isActive }) =>
  `text-sm transition-colors hover:text-foreground ${
    isActive ? 'text-foreground font-medium' : 'text-muted-foreground'
  }`;

function Navbar() {
  const navigate = useNavigate();
  const isAuthenticated = Boolean(localStorage.getItem('auth_token'));

  async function handleLogout() {
    try {
      await api.post('/logout');
    } catch {
      // The local session must still be cleared if the token has already expired.
    } finally {
      localStorage.removeItem('auth_token');
      navigate('/login', { replace: true });
    }
  }

  return (
    <header className="border-b bg-background">
      <nav className="mx-auto flex h-14 max-w-5xl items-center justify-between px-4">
        <Link to="/" className="font-semibold">
          Insurance Broker
        </Link>

        <div className="flex items-center gap-4">
          <NavLink to="/" end className={navLinkClass}>
            Калькулятор
          </NavLink>

          {isAuthenticated ? (
            <>
              <NavLink to="/my-applications" className={navLinkClass}>
                Мои заявки
              </NavLink>
              <NavLink to="/my-policies" className={navLinkClass}>
                Мои полисы
              </NavLink>
              <button
                type="button"
                onClick={handleLogout}
                className="text-sm text-muted-foreground transition-colors hover:text-foreground"
              >
                Выйти
              </button>
            </>
          ) : (
            <>
              <NavLink to="/login" className={navLinkClass}>
                Войти
              </NavLink>
              <NavLink to="/register" className={navLinkClass}>
                Регистрация
              </NavLink>
            </>
          )}
        </div>
      </nav>
    </header>
  );
}

export default Navbar;

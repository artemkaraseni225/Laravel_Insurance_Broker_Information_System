import { Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import ProtectedRoute from './components/ProtectedRoute';
import Login from './pages/Login';
import Register from './pages/Register';
import Calculator from './pages/Calculator';
import MyApplications from './pages/MyApplications';
import MyPolicies from './pages/MyPolicies';
import ApplicationDetail from './pages/ApplicationDetail';

function App() {
  return (
    <>
      <Navbar />
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/" element={<Calculator />} />
        <Route
          path="/my-applications"
          element={
            <ProtectedRoute allowedRoles={['customer']}>
              <MyApplications />
            </ProtectedRoute>
          }
        />
        <Route
          path="/my-applications/:id"
          element={
            <ProtectedRoute allowedRoles={['customer']}>
              <ApplicationDetail />
            </ProtectedRoute>
          }
        />
        <Route
          path="/my-policies"
          element={
            <ProtectedRoute allowedRoles={['customer']}>
              <MyPolicies />
            </ProtectedRoute>
          }
        />
      </Routes>
    </>
  );
}

export default App;

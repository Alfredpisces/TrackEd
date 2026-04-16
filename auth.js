/**
 * TrackEd – lightweight localStorage-based auth layer
 * No server required; works with plain static HTML files.
 */
const Auth = (() => {
  const SESSION_KEY = 'tracked_session';
  const USERS_KEY   = 'tracked_users';

  /** Pre-loaded demo accounts so the app works out-of-the-box */
  const DEMO_USERS = [
    { name: 'Maria Santos',    email: 'admin@deped.edu.ph',       password: 'Admin123',   role: 'Admin' },
    { name: 'Maria Santos',    email: 'schoolhead@deped.edu.ph',  password: 'Head123',    role: 'School Head' },
    { name: 'Grace Custodio',  email: 'counselor@deped.edu.ph',   password: 'Counsel123', role: 'Counselor' },
    { name: 'Juan Dela Cruz',  email: 'teacher@deped.edu.ph',     password: 'Teacher123', role: 'Teacher' },
  ];

  function _seed() {
    if (!localStorage.getItem(USERS_KEY)) {
      localStorage.setItem(USERS_KEY, JSON.stringify(DEMO_USERS));
    }
  }

  function _getUsers() {
    _seed();
    return JSON.parse(localStorage.getItem(USERS_KEY) || '[]');
  }

  return {
    /** Register a new account. Returns { ok, msg }. */
    register(name, email, password, role) {
      const users = _getUsers();
      if (users.find(u => u.email.toLowerCase() === email.toLowerCase())) {
        return { ok: false, msg: 'Email is already registered.' };
      }
      users.push({ name, email, password, role });
      localStorage.setItem(USERS_KEY, JSON.stringify(users));
      return { ok: true };
    },

    /** Login with email + password. Returns { ok, user?, msg? }. */
    login(email, password) {
      const users = _getUsers();
      const user  = users.find(u =>
        u.email.toLowerCase() === email.toLowerCase() && u.password === password
      );
      if (!user) return { ok: false, msg: 'Invalid email or password.' };
      localStorage.setItem(SESSION_KEY, JSON.stringify({
        name: user.name, role: user.role, email: user.email,
        initials: user.name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase()
      }));
      return { ok: true, user };
    },

    /** Destroy session and redirect to login. */
    logout() {
      localStorage.removeItem(SESSION_KEY);
      window.location.href = 'index.html';
    },

    /** Return current session object or null. */
    getUser() {
      const s = localStorage.getItem(SESSION_KEY);
      return s ? JSON.parse(s) : null;
    },

    /**
     * Call at the top of every protected page.
     * Redirects to login if no session; returns the user object if logged in.
     */
    require() {
      const user = this.getUser();
      if (!user) { window.location.replace('index.html'); return null; }
      return user;
    }
  };
})();

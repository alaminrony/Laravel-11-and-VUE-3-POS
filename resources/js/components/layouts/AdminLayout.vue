<template>
    <div class="admin-panel">
      <!-- Sidebar -->
      <aside class="sidebar">
        <h3 class="sidebar-title">Admin Panel</h3>
        <nav class="menu">
          <router-link to="/products" class="menu-item">Products</router-link>
          <router-link to="/categories" class="menu-item">Categories</router-link>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="content">
        <router-view />
      </main>
    </div>
  </template>

  <script>
  export default {
    name: "AdminLayout",
  };
  </script>

  <style scoped>
  .admin-panel {
    display: flex;
    min-height: 100vh;
  }

  .sidebar {
    width: 250px;
    background-color: #343a40;
    color: white;
    flex-shrink: 0;
    height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 20px 0;
  }

  .sidebar-title {
    text-align: center;
    margin-bottom: 20px;
    color: #fff;
  }

  .menu {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .menu-item {
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    transition: background-color 0.2s;
  }

  .menu-item:hover {
    background-color: #495057;
  }

  .content {
    flex-grow: 1;
    padding: 20px;
    background-color: #f8f9fa;
  }
  </style>

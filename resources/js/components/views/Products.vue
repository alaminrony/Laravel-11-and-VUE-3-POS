<template>
    <div>
      <h1>Products</h1>
      <button @click="addProduct" class="btn btn-primary">Add Product</button>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Price</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(product, index) in products" :key="product.id">
            <td>{{ index + 1 }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.price }}</td>
            <td>
              <button @click="editProduct(product)" class="btn btn-warning btn-sm">Edit</button>
              <button @click="deleteProduct(product.id)" class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script>
  export default {
    name: "Products",
    data() {
      return {
        products: [
          { id: 1, name: "Product A", price: 100 },
          { id: 2, name: "Product B", price: 200 },
        ],
      };
    },
    methods: {
      addProduct() {
        alert("Add Product");
      },
      editProduct(product) {
        alert(`Edit Product: ${product.name}`);
      },
      deleteProduct(id) {
        this.products = this.products.filter((product) => product.id !== id);
        alert("Product Deleted");
      },
    },
  };
  </script>

  <style scoped>
  .table {
    margin-top: 20px;
    width: 100%;
  }
  </style>

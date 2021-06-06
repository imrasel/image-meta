const axios = require("axios");

var header = {}; 
  header = {
    'Access-Control-Allow-Origin': '*'
  }

var axiosInstance = axios.create({
  baseURL: process.env.VUE_APP_API_URL,
  headers: header
});

module.exports = axiosInstance;
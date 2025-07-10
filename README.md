# Tasmota UI Dashboard

![Tasmota UI Logo Placeholder](https://via.placeholder.com/150x50?text=Tasmota+UI)

A simple, lightweight, and self-hosted web interface for controlling your Tasmota-powered smart devices.

This project provides a centralized dashboard to monitor and toggle the power state of your Tasmota devices, organized by custom types, directly from your web browser.

## ✨ Features

*   **Dynamic Device Listing:** Automatically displays devices based on your `devices.json` configuration.
*   **Real-time Status:** Fetches and displays the current power state of each device.
*   **One-Click Toggling:** Easily switch devices ON/OFF with a single click.
*   **Group Control API:** Send commands to entire groups of devices.
*   **Device Management API:** Add, delete, and list devices via simple API endpoints.
*   **Direct Access:** Quick links to each Tasmota device's native web interface.

## 🚀 Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

*   A web server (e.g., Apache, Nginx) with PHP support.
*   Tasmota-flashed devices connected to your local network.
*   PHP's `curl` extension enabled (for `getState` function).

### Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/tasmota-ui.git
    cd tasmota-ui
    ```
    *(Replace `https://github.com/your-username/tasmota-ui.git` with your actual repository URL)*

2.  **Place files on your web server:**
    Copy the `index.php`, `api.php`, `style.css`, and `devices.json` files to your web server's document root or a subdirectory accessible via your web server.

3.  **Configure `devices.json`:**
    Create or edit the `devices.json` file in the root of the project directory. This file defines your devices and their IP addresses. See the [Configuration](#-configuration) section for details.

4.  **Access in browser:**
    Open your web browser and navigate to the URL where you placed the files (e.g., `http://localhost/tasmota-ui/` or `http://your-server-ip/tasmota-ui/`).

## ⚙️ Configuration

The `devices.json` file is crucial for this dashboard to function. It's a JSON object where top-level keys represent device types (e.g., "Lights", "Fans"), and their values are objects mapping device names to their IP addresses.

**Example `devices.json`:**

```json
{
  "Lights": {
    "livingroom_light": "192.168.1.100",
    "bedroom_lamp": "192.168.1.101"
  },
  "Outlets": {
    "desk_outlet": "192.168.1.102"
  }
}
```

*   **`"Lights"` / `"Outlets"`:** These are your custom device types. You can name them anything you like.
*   **`"livingroom_light"` / `"bedroom_lamp"` / `"desk_outlet"`:** These are the unique names for your devices. These names are used in the API calls and will be displayed as friendly names (with underscores replaced by spaces) on the dashboard.
*   **`"192.168.1.100"`:** The IP address of your Tasmota device. Ensure these are correct and the devices are reachable from your web server.

## 🤝 Contributing

Contributions are welcome! If you have suggestions for improvements or new features, please open an issue or submit a pull request.

## 📄 License

This project is open-sourced under the MIT License. See the `LICENSE` file for more details. *(You may need to create a `LICENSE` file if you don't have one.)*
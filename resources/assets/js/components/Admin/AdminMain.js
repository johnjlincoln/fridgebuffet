import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class AdminMain extends Component {
    render () {
        return (
            <div>
                Admin dashboard.
            </div>
        )
    }
}

export default AdminMain;



if (document.getElementById('admin_main')) {
    ReactDOM.render(<AdminMain />, document.getElementById('admin_main'));
}

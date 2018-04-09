import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class AdminMain extends Component {
    render () {
        return (
            <div>
                Admin dashboard.
            </div>
        )
    }
}

if (document.getElementById('admin_main')) {
    ReactDOM.render(<AdminMain />, document.getElementById('admin_main'));
}

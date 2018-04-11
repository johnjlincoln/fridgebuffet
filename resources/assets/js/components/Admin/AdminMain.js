import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

class AdminMain extends Component {
    handleTest = (e) => {
        console.log('test');
    };

    render () {
        return (
            <div>
                <button onClick={this.handleTest}>Activate Lasers</button>
            </div>
        )
    }
}

export default AdminMain;
//
// if (document.getElementById('admin_main')) {
//     ReactDOM.render(<AdminMain />, document.getElementById('admin_main'));
// }

import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import AdminMain from '/AdminMain';

class AdminContainer extends Component {
    static propTypes = {
        test: PropTypes.string
    };

    static defaultProps = {
        test: 'string'
    };

    state = {
        test: this.props.test,
        lastRecipePage: 0,
        nextRecipePage: 0,
        nextRecipeId: 0
    };

    handleTest = (e) => {
        console.log('test');
    };

    render () {
        return (
            <div>
                <AdminMain />
            </div>
        )
    }
}

export default AdminContainer;

if (document.getElementById('admin_container')) {
    ReactDOM.render(<AdminContainer />, document.getElementById('admin_container'));
}

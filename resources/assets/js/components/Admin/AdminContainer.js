import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import AdminMain from './AdminMain';

class AdminContainer extends Component {
    state = {
        recentlyLoadedRecipes: {},
        lastRecipePageLoaded: null,
        nextRecipePageToLoad: null,
        lastRecipeLoaded: null,
        nextRecipeToLoad: null,
    };

    handleTest = () => {
        console.log('pew pew');
    };

    handleGetInitialState = () => {
        // fetch from backend
    };

    handleGetNewRecipe = () => {
        // trigger job
    };

    handleGetNewRecipePage = () => {
        // trigger job
    };

    componentDidMount() {
        this.handleGetInitialState;
    };

    render () {
        return (
            <div>
                <AdminMain
                    handleTest={this.handleTest}
                />
            </div>
        )
    }
}

export default AdminContainer;

if (document.getElementById('admin_container')) {
    ReactDOM.render(<AdminContainer />, document.getElementById('admin_container'));
}

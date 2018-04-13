import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import CoreDisplay from './CoreDisplay';

class CoreContainer extends Component {
    state = {
        recentlyLoadedRecipes: {},
        lastRecipePageLoaded: null,
        nextRecipePageToLoad: null,
        lastRecipeLoaded: null,
        nextRecipeToLoad: null,
    };

    handleGetInitialState = () => {
        // fetch from backend
    };

    componentDidMount() {
        this.handleGetInitialState;
    };

    render () {
        return (
            <div>
                <CoreDisplay />
            </div>
        )
    }
}

export default CoreContainer;

if (document.getElementById('core_container')) {
    ReactDOM.render(<CoreContainer />, document.getElementById('core_container'));
}

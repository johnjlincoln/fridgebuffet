import React from 'react'
import PropTypes from 'prop-types';

const test = () => {
    console.log('pew pew');
};

const AdminDisplay = props => {
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Admin Dashboard</div>
                        <div className="card-body">
                            <p>This is a temporary dashboard for monitoring the health of the F2F API.</p>
                        </div>
                        <div className="card-header">API Recipes Loaded: Total</div>
                        <div className="card-body">
                            {props.apiRecipesLoaded}
                        </div>
                        <div className="card-header">API Recipes Not Loaded: Total</div>
                        <div className="card-body">
                            {props.apiRecipesNotLoaded}
                        </div>
                        <div className="card-header">Last API Recipe Loaded:</div>
                        <div className="card-body">
                            {props.lastApiRecipeLoaded}
                        </div>
                        <div className="card-header">Next API Recipe To Load</div>
                        <div className="card-body">
                            {props.nextApiRecipeToLoad}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

AdminDisplay.propTypes = {
    apiRecipesLoaded: PropTypes.number,
    apiRecipesNotLoaded: PropTypes.number,
    lastApiRecipeLoaded: PropTypes.string,
    nextApiRecipeToLoad: PropTypes.string
};

AdminDisplay.defaultProps = {
    apiRecipesLoaded: 0,
    apiRecipesNotLoaded: 0,
    lastApiRecipeLoaded: '',
    nextApiRecipeToLoad: ''
};

export default AdminDisplay;

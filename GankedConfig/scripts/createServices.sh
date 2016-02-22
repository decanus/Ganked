#!/usr/bin/env bash

cf cs mongodb small lol-mongo
cf cs mongodb small mongo
cf cs redis small cache
cf cs redis small dataPool
cf cs redis small session

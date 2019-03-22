window.codex = window.codex || {}, window.codex.comments = function (t) {
    function e(e) {
        for (var n, r, o = e[0], s = e[1], a = 0, c = []; a < o.length; a ++) r = o[a], i[r] && c.push(i[r][0]), i[r] = 0;
        for (n in s) Object.prototype.hasOwnProperty.call(s, n) && (t[n] = s[n]);
        for (u && u(e); c.length;) c.shift()();
    }

    var n = {}, r = {comments: 0}, i = {comments: 0};

    function o(e) {
        if ( n[e] ) return n[e].exports;
        var r = n[e] = {i: e, l: ! 1, exports: {}};
        return t[e].call(r.exports, r, r.exports, o), r.l = ! 0, r.exports;
    }

    o.e = function (t) {
        var e = [];
        r[t] ? e.push(r[t]) : 0 !== r[t] && {'comments.style': 1}[t] && e.push(r[t] = new Promise(function (e, n) {
            for (var i = 'vendor/codex_core/css/' + ({'comments.style': 'comments.style'}[t] || t) + '.chunk.css?' + {'comments.style': '5440e9fd4a83f1eccf1a'}[t], s = o.p + i, a = document.getElementsByTagName('link'), c = 0; c < a.length; c ++) {
                var u = (f = a[c]).getAttribute('data-href') || f.getAttribute('href');
                if ( 'stylesheet' === f.rel && (u === i || u === s) ) return e();
            }
            var l = document.getElementsByTagName('style');
            for (c = 0; c < l.length; c ++) {
                var f;
                if ( (u = (f = l[c]).getAttribute('data-href')) === i || u === s ) return e();
            }
            var p = document.createElement('link');
            p.rel = 'stylesheet', p.type = 'text/css', p.onload = e, p.onerror = function (e) {
                var i = e && e.target && e.target.src || s, o = new Error('Loading CSS chunk ' + t + ' failed.\n(' + i + ')');
                o.request = i, delete r[t], p.parentNode.removeChild(p), n(o);
            }, p.href = s, document.getElementsByTagName('head')[0].appendChild(p);
        }).then(function () {
            r[t] = 0;
        }));
        var n = i[t];
        if ( 0 !== n ) if ( n ) e.push(n[2]); else {
            var s = new Promise(function (e, r) {
                n = i[t] = [e, r];
            });
            e.push(n[2] = s);
            var a, c = document.createElement('script');
            c.charset = 'utf-8', c.timeout = 120, o.nc && c.setAttribute('nonce', o.nc), c.src = function (t) {
                return o.p + 'vendor/codex_comments/js/chunk.' + ({'comments.style': 'comments.style'}[t] || t) + '.js';
            }(t), a = function (e) {
                c.onerror = c.onload = null, clearTimeout(u);
                var n = i[t];
                if ( 0 !== n ) {
                    if ( n ) {
                        var r = e && ('load' === e.type ? 'missing' : e.type), o = e && e.target && e.target.src, s = new Error('Loading chunk ' + t + ' failed.\n(' + r + ': ' + o + ')');
                        s.type = r, s.request = o, n[1](s);
                    }
                    i[t] = void 0;
                }
            };
            var u = setTimeout(function () {
                a({type: 'timeout', target: c});
            }, 12e4);
            c.onerror = c.onload = a, document.head.appendChild(c);
        }
        return Promise.all(e);
    }, o.m = t, o.c = n, o.d = function (t, e, n) {
        o.o(t, e) || Object.defineProperty(t, e, {enumerable: ! 0, get: n});
    }, o.r = function (t) {
        'undefined' !== typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {value: 'Module'}), Object.defineProperty(t, '__esModule', {value: ! 0});
    }, o.t = function (t, e) {
        if ( 1 & e && (t = o(t)), 8 & e ) return t;
        if ( 4 & e && 'object' === typeof t && t && t.__esModule ) return t;
        var n = Object.create(null);
        if ( o.r(n), Object.defineProperty(n, 'default', {enumerable: ! 0, value: t}), 2 & e && 'string' != typeof t ) for (var r in t) o.d(n, r, function (e) {
            return t[e];
        }.bind(null, r));
        return n;
    }, o.n = function (t) {
        var e = t && t.__esModule ? function () {
            return t.default;
        } : function () {
            return t;
        };
        return o.d(e, 'a', e), e;
    }, o.o = function (t, e) {
        return Object.prototype.hasOwnProperty.call(t, e);
    }, o.p = '/', o.oe = function (t) {
        throw console.error(t), t;
    };
    var s = window.webpackJsonp = window.webpackJsonp || [], a = s.push.bind(s);
    s.push = e, s = s.slice();
    for (var c = 0; c < s.length; c ++) e(s[c]);
    var u = a;
    return o(o.s = 3);
}({
    '../node_modules/bluebird-global/index.js'          : function (t, e, n) {
        (function (e) {
            var r = n('../node_modules/bluebird/js/browser/bluebird.js');
            e.Promise = r, t.exports = r;
        }).call(this, n('../node_modules/webpack/buildin/global.js'));
    }, '../node_modules/bluebird/js/browser/bluebird.js': function (t, e, n) {
        (function (e, n, r) {
            var i;
            i = function () {
                var t, o, s;
                return function t(e, n, r) {
                    function i(s, a) {
                        if ( ! n[s] ) {
                            if ( ! e[s] ) {
                                var c = 'function' == typeof _dereq_ && _dereq_;
                                if ( ! a && c ) return c(s, ! 0);
                                if ( o ) return o(s, ! 0);
                                var u = new Error('Cannot find module \'' + s + '\'');
                                throw u.code = 'MODULE_NOT_FOUND', u;
                            }
                            var l = n[s] = {exports: {}};
                            e[s][0].call(l.exports, function (t) {
                                var n = e[s][1][t];
                                return i(n || t);
                            }, l, l.exports, t, e, n, r);
                        }
                        return n[s].exports;
                    }

                    for (var o = 'function' == typeof _dereq_ && _dereq_, s = 0; s < r.length; s ++) i(r[s]);
                    return i;
                }({
                    1                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 : [function (t, e, n) {
                        'use strict';
                        e.exports = function (t) {
                            var e = t._SomePromiseArray;

                            function n(t) {
                                var n = new e(t), r = n.promise();
                                return n.setHowMany(1), n.setUnwrap(), n.init(), r;
                            }

                            t.any = function (t) {
                                return n(t);
                            }, t.prototype.any = function () {
                                return n(this);
                            };
                        };
                    }, {}], 2                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         : [function (t, n, r) {
                        'use strict';
                        var o;
                        try {
                            throw new Error;
                        } catch (i) {
                            o = i;
                        }
                        var s = t('./schedule'), a = t('./queue'), c = t('./util');

                        function u() {
                            this._customScheduler = ! 1, this._isTickUsed = ! 1, this._lateQueue = new a(16), this._normalQueue = new a(16), this._haveDrainedQueues = ! 1, this._trampolineEnabled = ! 0;
                            var t = this;
                            this.drainQueues = function () {
                                t._drainQueues();
                            }, this._schedule = s;
                        }

                        function l(t, e, n) {
                            this._lateQueue.push(t, e, n), this._queueTick();
                        }

                        function f(t, e, n) {
                            this._normalQueue.push(t, e, n), this._queueTick();
                        }

                        function p(t) {
                            this._normalQueue._pushOne(t), this._queueTick();
                        }

                        function h(t) {
                            for (; t.length() > 0;) d(t);
                        }

                        function d(t) {
                            var e = t.shift();
                            if ( 'function' !== typeof e ) e._settlePromises(); else {
                                var n = t.shift(), r = t.shift();
                                e.call(n, r);
                            }
                        }

                        u.prototype.setScheduler = function (t) {
                            var e = this._schedule;
                            return this._schedule = t, this._customScheduler = ! 0, e;
                        }, u.prototype.hasCustomScheduler = function () {
                            return this._customScheduler;
                        }, u.prototype.enableTrampoline = function () {
                            this._trampolineEnabled = ! 0;
                        }, u.prototype.disableTrampolineIfNecessary = function () {
                            c.hasDevTools && (this._trampolineEnabled = ! 1);
                        }, u.prototype.haveItemsQueued = function () {
                            return this._isTickUsed || this._haveDrainedQueues;
                        }, u.prototype.fatalError = function (t, n) {
                            n ? (e.stderr.write('Fatal ' + (t instanceof Error ? t.stack : t) + '\n'), e.exit(2)) : this.throwLater(t);
                        }, u.prototype.throwLater = function (t, e) {
                            if ( 1 === arguments.length && (e = t, t = function () {
                                throw e;
                            }), 'undefined' !== typeof setTimeout ) setTimeout(function () {
                                t(e);
                            }, 0); else try {
                                this._schedule(function () {
                                    t(e);
                                });
                            } catch (i) {
                                throw new Error('No async scheduler available\n\n    See http://goo.gl/MqrFmX\n');
                            }
                        }, c.hasDevTools ? (u.prototype.invokeLater = function (t, e, n) {
                            this._trampolineEnabled ? l.call(this, t, e, n) : this._schedule(function () {
                                setTimeout(function () {
                                    t.call(e, n);
                                }, 100);
                            });
                        }, u.prototype.invoke = function (t, e, n) {
                            this._trampolineEnabled ? f.call(this, t, e, n) : this._schedule(function () {
                                t.call(e, n);
                            });
                        }, u.prototype.settlePromises = function (t) {
                            this._trampolineEnabled ? p.call(this, t) : this._schedule(function () {
                                t._settlePromises();
                            });
                        }) : (u.prototype.invokeLater = l, u.prototype.invoke = f, u.prototype.settlePromises = p), u.prototype._drainQueues = function () {
                            h(this._normalQueue), this._reset(), this._haveDrainedQueues = ! 0, h(this._lateQueue);
                        }, u.prototype._queueTick = function () {
                            this._isTickUsed || (this._isTickUsed = ! 0, this._schedule(this.drainQueues));
                        }, u.prototype._reset = function () {
                            this._isTickUsed = ! 1;
                        }, n.exports = u, n.exports.firstLineError = o;
                    }, {'./queue': 26, './schedule': 29, './util': 36}], 3                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (t, e, n, r) {
                            var i = ! 1, o = function (t, e) {
                                this._reject(e);
                            }, s  = function (t, e) {
                                e.promiseRejectionQueued = ! 0, e.bindingPromise._then(o, o, null, this, t);
                            }, a  = function (t, e) {
                                0 === (50397184 & this._bitField) && this._resolveCallback(e.target);
                            }, c  = function (t, e) {
                                e.promiseRejectionQueued || this._reject(t);
                            };
                            t.prototype.bind = function (o) {
                                i || (i = ! 0, t.prototype._propagateFrom = r.propagateFromFunction(), t.prototype._boundValue = r.boundValueFunction());
                                var u = n(o), l = new t(e);
                                l._propagateFrom(this, 1);
                                var f = this._target();
                                if ( l._setBoundTo(u), u instanceof t ) {
                                    var p = {promiseRejectionQueued: ! 1, promise: l, target: f, bindingPromise: u};
                                    f._then(e, s, void 0, l, p), u._then(a, c, void 0, l, p), l._setOnCancel(u);
                                } else l._resolveCallback(f);
                                return l;
                            }, t.prototype._setBoundTo = function (t) {
                                void 0 !== t ? (this._bitField = 2097152 | this._bitField, this._boundTo = t) : this._bitField = - 2097153 & this._bitField;
                            }, t.prototype._isBound = function () {
                                return 2097152 === (2097152 & this._bitField);
                            }, t.bind = function (e, n) {
                                return t.resolve(n).bind(e);
                            };
                        };
                    }, {}], 4                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         : [function (t, e, n) {
                        'use strict';
                        var r;
                        'undefined' !== typeof Promise && (r = Promise);
                        var o = t('./promise')();
                        o.noConflict = function () {
                            try {
                                Promise === o && (Promise = r);
                            } catch (i) {
                            }
                            return o;
                        }, e.exports = o;
                    }, {'./promise': 22}], 5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          : [function (t, e, n) {
                        'use strict';
                        var r = Object.create;
                        if ( r ) {
                            var i = r(null), o = r(null);
                            i[' size'] = o[' size'] = 0;
                        }
                        e.exports = function (e) {
                            var n = t('./util'), r = n.canEvaluate;
                            n.isIdentifier;

                            function i(t) {
                                return function (t, r) {
                                    var i;
                                    if ( null != t && (i = t[r]), 'function' !== typeof i ) {
                                        var o = 'Object ' + n.classString(t) + ' has no method \'' + n.toString(r) + '\'';
                                        throw new e.TypeError(o);
                                    }
                                    return i;
                                }(t, this.pop()).apply(t, this);
                            }

                            function o(t) {
                                return t[this];
                            }

                            function s(t) {
                                var e = + this;
                                return e < 0 && (e = Math.max(0, e + t.length)), t[e];
                            }

                            e.prototype.call = function (t) {
                                var e = [].slice.call(arguments, 1);
                                return e.push(t), this._then(i, void 0, void 0, e, void 0);
                            }, e.prototype.get = function (t) {
                                var e;
                                if ( 'number' === typeof t ) e = s; else if ( r ) {
                                    var n = (void 0)(t);
                                    e = null !== n ? n : o;
                                } else e = o;
                                return this._then(e, void 0, void 0, t, void 0);
                            };
                        };
                    }, {'./util': 36}], 6                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, i) {
                            var o = t('./util'), s = o.tryCatch, a = o.errorObj, c = e._async;
                            e.prototype.break = e.prototype.cancel = function () {
                                if ( ! i.cancellation() ) return this._warn('cancellation is disabled');
                                for (var t = this, e = t; t._isCancellable();) {
                                    if ( ! t._cancelBy(e) ) {
                                        e._isFollowing() ? e._followee().cancel() : e._cancelBranched();
                                        break;
                                    }
                                    var n = t._cancellationParent;
                                    if ( null == n || ! n._isCancellable() ) {
                                        t._isFollowing() ? t._followee().cancel() : t._cancelBranched();
                                        break;
                                    }
                                    t._isFollowing() && t._followee().cancel(), t._setWillBeCancelled(), e = t, t = n;
                                }
                            }, e.prototype._branchHasCancelled = function () {
                                this._branchesRemainingToCancel --;
                            }, e.prototype._enoughBranchesHaveCancelled = function () {
                                return void 0 === this._branchesRemainingToCancel || this._branchesRemainingToCancel <= 0;
                            }, e.prototype._cancelBy = function (t) {
                                return t === this ? (this._branchesRemainingToCancel = 0, this._invokeOnCancel(), ! 0) : (this._branchHasCancelled(), ! ! this._enoughBranchesHaveCancelled() && (this._invokeOnCancel(), ! 0));
                            }, e.prototype._cancelBranched = function () {
                                this._enoughBranchesHaveCancelled() && this._cancel();
                            }, e.prototype._cancel = function () {
                                this._isCancellable() && (this._setCancelled(), c.invoke(this._cancelPromises, this, void 0));
                            }, e.prototype._cancelPromises = function () {
                                this._length() > 0 && this._settlePromises();
                            }, e.prototype._unsetOnCancel = function () {
                                this._onCancelField = void 0;
                            }, e.prototype._isCancellable = function () {
                                return this.isPending() && ! this._isCancelled();
                            }, e.prototype.isCancellable = function () {
                                return this.isPending() && ! this.isCancelled();
                            }, e.prototype._doInvokeOnCancel = function (t, e) {
                                if ( o.isArray(t) ) for (var n = 0; n < t.length; ++ n) this._doInvokeOnCancel(t[n], e); else if ( void 0 !== t ) if ( 'function' === typeof t ) {
                                    if ( ! e ) {
                                        var r = s(t).call(this._boundValue());
                                        r === a && (this._attachExtraTrace(r.e), c.throwLater(r.e));
                                    }
                                } else t._resultCancelled(this);
                            }, e.prototype._invokeOnCancel = function () {
                                var t = this._onCancel();
                                this._unsetOnCancel(), c.invoke(this._doInvokeOnCancel, this, t);
                            }, e.prototype._invokeInternalOnCancel = function () {
                                this._isCancellable() && (this._doInvokeOnCancel(this._onCancel(), ! 0), this._unsetOnCancel());
                            }, e.prototype._resultCancelled = function () {
                                this.cancel();
                            };
                        };
                    }, {'./util': 36}], 7                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e) {
                            var n = t('./util'), r = t('./es5').keys, i = n.tryCatch, o = n.errorObj;
                            return function (t, s, a) {
                                return function (c) {
                                    var u = a._boundValue();
                                    t:for (var l = 0; l < t.length; ++ l) {
                                        var f = t[l];
                                        if ( f === Error || null != f && f.prototype instanceof Error ) {
                                            if ( c instanceof f ) return i(s).call(u, c);
                                        } else if ( 'function' === typeof f ) {
                                            var p = i(f).call(u, c);
                                            if ( p === o ) return p;
                                            if ( p ) return i(s).call(u, c);
                                        } else if ( n.isObject(c) ) {
                                            for (var h = r(f), d = 0; d < h.length; ++ d) {
                                                var _ = h[d];
                                                if ( f[_] != c[_] ) continue t;
                                            }
                                            return i(s).call(u, c);
                                        }
                                    }
                                    return e;
                                };
                            };
                        };
                    }, {'./es5': 13, './util': 36}], 8                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                : [function (t, e, n) {
                        'use strict';
                        e.exports = function (t) {
                            var e = ! 1, n = [];

                            function r() {
                                this._trace = new r.CapturedTrace(i());
                            }

                            function i() {
                                var t = n.length - 1;
                                if ( t >= 0 ) return n[t];
                            }

                            return t.prototype._promiseCreated = function () {
                            }, t.prototype._pushContext = function () {
                            }, t.prototype._popContext = function () {
                                return null;
                            }, t._peekContext = t.prototype._peekContext = function () {
                            }, r.prototype._pushContext = function () {
                                void 0 !== this._trace && (this._trace._promiseCreated = null, n.push(this._trace));
                            }, r.prototype._popContext = function () {
                                if ( void 0 !== this._trace ) {
                                    var t = n.pop(), e = t._promiseCreated;
                                    return t._promiseCreated = null, e;
                                }
                                return null;
                            }, r.CapturedTrace = null, r.create = function () {
                                if ( e ) return new r;
                            }, r.deactivateLongStackTraces = function () {
                            }, r.activateLongStackTraces = function () {
                                var n = t.prototype._pushContext, o = t.prototype._popContext, s = t._peekContext, a = t.prototype._peekContext, c = t.prototype._promiseCreated;
                                r.deactivateLongStackTraces = function () {
                                    t.prototype._pushContext = n, t.prototype._popContext = o, t._peekContext = s, t.prototype._peekContext = a, t.prototype._promiseCreated = c, e = ! 1;
                                }, e = ! 0, t.prototype._pushContext = r.prototype._pushContext, t.prototype._popContext = r.prototype._popContext, t._peekContext = t.prototype._peekContext = i, t.prototype._promiseCreated = function () {
                                    var t = this._peekContext();
                                    t && null == t._promiseCreated && (t._promiseCreated = this);
                                };
                            }, r;
                        };
                    }, {}], 9                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         : [function (t, n, r) {
                        'use strict';
                        n.exports = function (n, r) {
                            var o, s, a, c = n._getDomain, u = n._async, l = t('./errors').Warning, f = t('./util'), p = t('./es5'), h = f.canAttachTrace, d = /[\\\/]bluebird[\\\/]js[\\\/](release|debug|instrumented)/, _ = /\((?:timers\.js):\d+:\d+\)/, v = /[\/<\(](.+?):(\d+):(\d+)\)?\s*$/, y = null, m = null, g = ! 1, b = ! (0 == f.env('BLUEBIRD_DEBUG')), C = ! (0 == f.env('BLUEBIRD_WARNINGS') || ! b && ! f.env('BLUEBIRD_WARNINGS')), w = ! (0 == f.env('BLUEBIRD_LONG_STACK_TRACES') || ! b && ! f.env('BLUEBIRD_LONG_STACK_TRACES')), j = 0 != f.env('BLUEBIRD_W_FORGOTTEN_RETURN') && (C || ! ! f.env('BLUEBIRD_W_FORGOTTEN_RETURN'));
                            n.prototype.suppressUnhandledRejections = function () {
                                var t = this._target();
                                t._bitField = - 1048577 & t._bitField | 524288;
                            }, n.prototype._ensurePossibleRejectionHandled = function () {
                                if ( 0 === (524288 & this._bitField) ) {
                                    this._setRejectionIsUnhandled();
                                    var t = this;
                                    setTimeout(function () {
                                        t._notifyUnhandledRejection();
                                    }, 1);
                                }
                            }, n.prototype._notifyUnhandledRejectionIsHandled = function () {
                                z('rejectionHandled', o, void 0, this);
                            }, n.prototype._setReturnedNonUndefined = function () {
                                this._bitField = 268435456 | this._bitField;
                            }, n.prototype._returnedNonUndefined = function () {
                                return 0 !== (268435456 & this._bitField);
                            }, n.prototype._notifyUnhandledRejection = function () {
                                if ( this._isRejectionUnhandled() ) {
                                    var t = this._settledValue();
                                    this._setUnhandledRejectionIsNotified(), z('unhandledRejection', s, t, this);
                                }
                            }, n.prototype._setUnhandledRejectionIsNotified = function () {
                                this._bitField = 262144 | this._bitField;
                            }, n.prototype._unsetUnhandledRejectionIsNotified = function () {
                                this._bitField = - 262145 & this._bitField;
                            }, n.prototype._isUnhandledRejectionNotified = function () {
                                return (262144 & this._bitField) > 0;
                            }, n.prototype._setRejectionIsUnhandled = function () {
                                this._bitField = 1048576 | this._bitField;
                            }, n.prototype._unsetRejectionIsUnhandled = function () {
                                this._bitField = - 1048577 & this._bitField, this._isUnhandledRejectionNotified() && (this._unsetUnhandledRejectionIsNotified(), this._notifyUnhandledRejectionIsHandled());
                            }, n.prototype._isRejectionUnhandled = function () {
                                return (1048576 & this._bitField) > 0;
                            }, n.prototype._warn = function (t, e, n) {
                                return H(t, e, n || this);
                            }, n.onPossiblyUnhandledRejection = function (t) {
                                var e = c();
                                s = 'function' === typeof t ? null === e ? t : f.domainBind(e, t) : void 0;
                            }, n.onUnhandledRejectionHandled = function (t) {
                                var e = c();
                                o = 'function' === typeof t ? null === e ? t : f.domainBind(e, t) : void 0;
                            };
                            var F = function () {
                            };
                            n.longStackTraces = function () {
                                if ( u.haveItemsQueued() && ! tt.longStackTraces ) throw new Error('cannot enable long stack traces after promises have been created\n\n    See http://goo.gl/MqrFmX\n');
                                if ( ! tt.longStackTraces && X() ) {
                                    var t = n.prototype._captureStackTrace, e = n.prototype._attachExtraTrace, i = n.prototype._dereferenceTrace;
                                    tt.longStackTraces = ! 0, F = function () {
                                        if ( u.haveItemsQueued() && ! tt.longStackTraces ) throw new Error('cannot enable long stack traces after promises have been created\n\n    See http://goo.gl/MqrFmX\n');
                                        n.prototype._captureStackTrace = t, n.prototype._attachExtraTrace = e, n.prototype._dereferenceTrace = i, r.deactivateLongStackTraces(), u.enableTrampoline(), tt.longStackTraces = ! 1;
                                    }, n.prototype._captureStackTrace = M, n.prototype._attachExtraTrace = U, n.prototype._dereferenceTrace = B, r.activateLongStackTraces(), u.disableTrampolineIfNecessary();
                                }
                            }, n.hasLongStackTraces = function () {
                                return tt.longStackTraces && X();
                            };
                            var k  = function () {
                                try {
                                    if ( 'function' === typeof CustomEvent ) {
                                        var t = new CustomEvent('CustomEvent');
                                        return f.global.dispatchEvent(t), function (t, e) {
                                            var n = {detail: e, cancelable: ! 0};
                                            p.defineProperty(n, 'promise', {value: e.promise}), p.defineProperty(n, 'reason', {value: e.reason});
                                            var r = new CustomEvent(t.toLowerCase(), n);
                                            return ! f.global.dispatchEvent(r);
                                        };
                                    }
                                    if ( 'function' === typeof Event ) {
                                        t = new Event('CustomEvent');
                                        return f.global.dispatchEvent(t), function (t, e) {
                                            var n = new Event(t.toLowerCase(), {cancelable: ! 0});
                                            return n.detail = e, p.defineProperty(n, 'promise', {value: e.promise}), p.defineProperty(n, 'reason', {value: e.reason}), ! f.global.dispatchEvent(n);
                                        };
                                    }
                                    return (t = document.createEvent('CustomEvent')).initCustomEvent('testingtheevent', ! 1, ! 0, {}), f.global.dispatchEvent(t), function (t, e) {
                                        var n = document.createEvent('CustomEvent');
                                        return n.initCustomEvent(t.toLowerCase(), ! 1, ! 0, e), ! f.global.dispatchEvent(n);
                                    };
                                } catch (i) {
                                }
                                return function () {
                                    return ! 1;
                                };
                            }(), E = f.isNode ? function () {
                                return e.emit.apply(e, arguments);
                            } : f.global ? function (t) {
                                var e = 'on' + t.toLowerCase(), n = f.global[e];
                                return ! ! n && (n.apply(f.global, [].slice.call(arguments, 1)), ! 0);
                            } : function () {
                                return ! 1;
                            };

                            function x(t, e) {
                                return {promise: e};
                            }

                            var T = {
                                promiseCreated       : x, promiseFulfilled: x, promiseRejected: x, promiseResolved: x, promiseCancelled: x, promiseChained: function (t, e, n) {
                                    return {promise: e, child: n};
                                }, warning           : function (t, e) {
                                    return {warning: e};
                                }, unhandledRejection: function (t, e, n) {
                                    return {reason: e, promise: n};
                                }, rejectionHandled  : x
                            }, P  = function (t) {
                                var e = ! 1;
                                try {
                                    e = E.apply(null, arguments);
                                } catch (i) {
                                    u.throwLater(i), e = ! 0;
                                }
                                var n = ! 1;
                                try {
                                    n = k(t, T[t].apply(null, arguments));
                                } catch (i) {
                                    u.throwLater(i), n = ! 0;
                                }
                                return n || e;
                            };

                            function O() {
                                return ! 1;
                            }

                            function S(t, e, n) {
                                var r = this;
                                try {
                                    t(e, n, function (t) {
                                        if ( 'function' !== typeof t ) throw new TypeError('onCancel must be a function, got: ' + f.toString(t));
                                        r._attachCancellationCallback(t);
                                    });
                                } catch (i) {
                                    return i;
                                }
                            }

                            function R(t) {
                                if ( ! this._isCancellable() ) return this;
                                var e = this._onCancel();
                                void 0 !== e ? f.isArray(e) ? e.push(t) : this._setOnCancel([e, t]) : this._setOnCancel(t);
                            }

                            function A() {
                                return this._onCancelField;
                            }

                            function I(t) {
                                this._onCancelField = t;
                            }

                            function N() {
                                this._cancellationParent = void 0, this._onCancelField = void 0;
                            }

                            function D(t, e) {
                                if ( 0 !== (1 & e) ) {
                                    this._cancellationParent = t;
                                    var n = t._branchesRemainingToCancel;
                                    void 0 === n && (n = 0), t._branchesRemainingToCancel = n + 1;
                                }
                                0 !== (2 & e) && t._isBound() && this._setBoundTo(t._boundTo);
                            }

                            n.config = function (t) {
                                if ( 'longStackTraces' in (t = Object(t)) && (t.longStackTraces ? n.longStackTraces() : ! t.longStackTraces && n.hasLongStackTraces() && F()), 'warnings' in t ) {
                                    var e = t.warnings;
                                    tt.warnings = ! ! e, j = tt.warnings, f.isObject(e) && 'wForgottenReturn' in e && (j = ! ! e.wForgottenReturn);
                                }
                                if ( 'cancellation' in t && t.cancellation && ! tt.cancellation ) {
                                    if ( u.haveItemsQueued() ) throw new Error('cannot enable cancellation after promises are in use');
                                    n.prototype._clearCancellationData = N, n.prototype._propagateFrom = D, n.prototype._onCancel = A, n.prototype._setOnCancel = I, n.prototype._attachCancellationCallback = R, n.prototype._execute = S, L = D, tt.cancellation = ! 0;
                                }
                                return 'monitoring' in t && (t.monitoring && ! tt.monitoring ? (tt.monitoring = ! 0, n.prototype._fireEvent = P) : ! t.monitoring && tt.monitoring && (tt.monitoring = ! 1, n.prototype._fireEvent = O)), n;
                            }, n.prototype._fireEvent = O, n.prototype._execute = function (t, e, n) {
                                try {
                                    t(e, n);
                                } catch (i) {
                                    return i;
                                }
                            }, n.prototype._onCancel = function () {
                            }, n.prototype._setOnCancel = function (t) {
                            }, n.prototype._attachCancellationCallback = function (t) {
                            }, n.prototype._captureStackTrace = function () {
                            }, n.prototype._attachExtraTrace = function () {
                            }, n.prototype._dereferenceTrace = function () {
                            }, n.prototype._clearCancellationData = function () {
                            }, n.prototype._propagateFrom = function (t, e) {
                            };
                            var L = function (t, e) {
                                0 !== (2 & e) && t._isBound() && this._setBoundTo(t._boundTo);
                            };

                            function V() {
                                var t = this._boundTo;
                                return void 0 !== t && t instanceof n ? t.isFulfilled() ? t.value() : void 0 : t;
                            }

                            function M() {
                                this._trace = new Z(this._peekContext());
                            }

                            function U(t, e) {
                                if ( h(t) ) {
                                    var n = this._trace;
                                    if ( void 0 !== n && e && (n = n._parent), void 0 !== n ) n.attachExtraTrace(t); else if ( ! t.__stackCleaned__ ) {
                                        var r = $(t);
                                        f.notEnumerableProp(t, 'stack', r.message + '\n' + r.stack.join('\n')), f.notEnumerableProp(t, '__stackCleaned__', ! 0);
                                    }
                                }
                            }

                            function B() {
                                this._trace = void 0;
                            }

                            function H(t, e, r) {
                                if ( tt.warnings ) {
                                    var i, o = new l(t);
                                    if ( e ) r._attachExtraTrace(o); else if ( tt.longStackTraces && (i = n._peekContext()) ) i.attachExtraTrace(o); else {
                                        var s = $(o);
                                        o.stack = s.message + '\n' + s.stack.join('\n');
                                    }
                                    P('warning', o) || Q(o, '', ! 0);
                                }
                            }

                            function q(t) {
                                for (var e = [], n = 0; n < t.length; ++ n) {
                                    var r = t[n], i = '    (No stack trace)' === r || y.test(r), o = i && W(r);
                                    i && ! o && (g && ' ' !== r.charAt(0) && (r = '    ' + r), e.push(r));
                                }
                                return e;
                            }

                            function $(t) {
                                var e = t.stack, n = t.toString();
                                return e = 'string' === typeof e && e.length > 0 ? function (t) {
                                    for (var e = t.stack.replace(/\s+$/g, '').split('\n'), n = 0; n < e.length; ++ n) {
                                        var r = e[n];
                                        if ( '    (No stack trace)' === r || y.test(r) ) break;
                                    }
                                    return n > 0 && 'SyntaxError' != t.name && (e = e.slice(n)), e;
                                }(t) : ['    (No stack trace)'], {message: n, stack: 'SyntaxError' == t.name ? e : q(e)};
                            }

                            function Q(t, e, n) {
                                if ( 'undefined' !== typeof console ) {
                                    var r;
                                    if ( f.isObject(t) ) {
                                        var i = t.stack;
                                        r = e + m(i, t);
                                    } else r = e + String(t);
                                    'function' === typeof a ? a(r, n) : 'function' !== typeof console.log && 'object' !== typeof console.log || console.log(r);
                                }
                            }

                            function z(t, e, n, r) {
                                var o = ! 1;
                                try {
                                    'function' === typeof e && (o = ! 0, 'rejectionHandled' === t ? e(r) : e(n, r));
                                } catch (i) {
                                    u.throwLater(i);
                                }
                                'unhandledRejection' === t ? P(t, n, r) || o || Q(n, 'Unhandled rejection ') : P(t, r);
                            }

                            function G(t) {
                                var e;
                                if ( 'function' === typeof t ) e = '[function ' + (t.name || 'anonymous') + ']'; else {
                                    e = t && 'function' === typeof t.toString ? t.toString() : f.toString(t);
                                    if ( /\[object [a-zA-Z0-9$_]+\]/.test(e) ) try {
                                        e = JSON.stringify(t);
                                    } catch (i) {
                                    }
                                    0 === e.length && (e = '(empty array)');
                                }
                                return '(<' + function (t) {
                                    if ( t.length < 41 ) return t;
                                    return t.substr(0, 38) + '...';
                                }(e) + '>, no stack trace)';
                            }

                            function X() {
                                return 'function' === typeof Y;
                            }

                            var W = function () {
                                return ! 1;
                            }, J  = /[\/<\(]([^:\/]+):(\d+):(?:\d+)\)?\s*$/;

                            function K(t) {
                                var e = t.match(J);
                                if ( e ) return {fileName: e[1], line: parseInt(e[2], 10)};
                            }

                            function Z(t) {
                                this._parent = t, this._promisesCreated = 0;
                                var e = this._length = 1 + (void 0 === t ? 0 : t._length);
                                Y(this, Z), e > 32 && this.uncycle();
                            }

                            f.inherits(Z, Error), r.CapturedTrace = Z, Z.prototype.uncycle = function () {
                                var t = this._length;
                                if ( ! (t < 2) ) {
                                    for (var e = [], n = {}, r = 0, i = this; void 0 !== i; ++ r) e.push(i), i = i._parent;
                                    for (r = (t = this._length = r) - 1; r >= 0; -- r) {
                                        var o = e[r].stack;
                                        void 0 === n[o] && (n[o] = r);
                                    }
                                    for (r = 0; r < t; ++ r) {
                                        var s = n[e[r].stack];
                                        if ( void 0 !== s && s !== r ) {
                                            s > 0 && (e[s - 1]._parent = void 0, e[s - 1]._length = 1), e[r]._parent = void 0, e[r]._length = 1;
                                            var a = r > 0 ? e[r - 1] : this;
                                            s < t - 1 ? (a._parent = e[s + 1], a._parent.uncycle(), a._length = a._parent._length + 1) : (a._parent = void 0, a._length = 1);
                                            for (var c = a._length + 1, u = r - 2; u >= 0; -- u) e[u]._length = c, c ++;
                                            return;
                                        }
                                    }
                                }
                            }, Z.prototype.attachExtraTrace = function (t) {
                                if ( ! t.__stackCleaned__ ) {
                                    this.uncycle();
                                    for (var e = $(t), n = e.message, r = [e.stack], i = this; void 0 !== i;) r.push(q(i.stack.split('\n'))), i = i._parent;
                                    ! function (t) {
                                        for (var e = t[0], n = 1; n < t.length; ++ n) {
                                            for (var r = t[n], i = e.length - 1, o = e[i], s = - 1, a = r.length - 1; a >= 0; -- a) if ( r[a] === o ) {
                                                s = a;
                                                break;
                                            }
                                            for (a = s; a >= 0; -- a) {
                                                var c = r[a];
                                                if ( e[i] !== c ) break;
                                                e.pop(), i --;
                                            }
                                            e = r;
                                        }
                                    }(r), function (t) {
                                        for (var e = 0; e < t.length; ++ e) (0 === t[e].length || e + 1 < t.length && t[e][0] === t[e + 1][0]) && (t.splice(e, 1), e --);
                                    }(r), f.notEnumerableProp(t, 'stack', function (t, e) {
                                        for (var n = 0; n < e.length - 1; ++ n) e[n].push('From previous event:'), e[n] = e[n].join('\n');
                                        return n < e.length && (e[n] = e[n].join('\n')), t + '\n' + e.join('\n');
                                    }(n, r)), f.notEnumerableProp(t, '__stackCleaned__', ! 0);
                                }
                            };
                            var Y = function () {
                                var t = /^\s*at\s*/, e = function (t, e) {
                                    return 'string' === typeof t ? t : void 0 !== e.name && void 0 !== e.message ? e.toString() : G(e);
                                };
                                if ( 'number' === typeof Error.stackTraceLimit && 'function' === typeof Error.captureStackTrace ) {
                                    Error.stackTraceLimit += 6, y = t, m = e;
                                    var n = Error.captureStackTrace;
                                    return W = function (t) {
                                        return d.test(t);
                                    }, function (t, e) {
                                        Error.stackTraceLimit += 6, n(t, e), Error.stackTraceLimit -= 6;
                                    };
                                }
                                var r, o = new Error;
                                if ( 'string' === typeof o.stack && o.stack.split('\n')[0].indexOf('stackDetection@') >= 0 ) return y = /@/, m = e, g = ! 0, function (t) {
                                    t.stack = (new Error).stack;
                                };
                                try {
                                    throw new Error;
                                } catch (i) {
                                    r = 'stack' in i;
                                }
                                return 'stack' in o || ! r || 'number' !== typeof Error.stackTraceLimit ? (m = function (t, e) {
                                    return 'string' === typeof t ? t : 'object' !== typeof e && 'function' !== typeof e || void 0 === e.name || void 0 === e.message ? G(e) : e.toString();
                                }, null) : (y = t, m = e, function (t) {
                                    Error.stackTraceLimit += 6;
                                    try {
                                        throw new Error;
                                    } catch (i) {
                                        t.stack = i.stack;
                                    }
                                    Error.stackTraceLimit -= 6;
                                });
                            }();
                            'undefined' !== typeof console && 'undefined' !== typeof console.warn && (a = function (t) {
                                console.warn(t);
                            }, f.isNode && e.stderr.isTTY ? a = function (t, e) {
                                var n = e ? '\x1b[33m' : '\x1b[31m';
                                console.warn(n + t + '\x1b[0m\n');
                            } : f.isNode || 'string' !== typeof (new Error).stack || (a = function (t, e) {
                                console.warn('%c' + t, e ? 'color: darkorange' : 'color: red');
                            }));
                            var tt = {warnings: C, longStackTraces: ! 1, cancellation: ! 1, monitoring: ! 1};
                            return w && n.longStackTraces(), {
                                longStackTraces         : function () {
                                    return tt.longStackTraces;
                                }, warnings             : function () {
                                    return tt.warnings;
                                }, cancellation         : function () {
                                    return tt.cancellation;
                                }, monitoring           : function () {
                                    return tt.monitoring;
                                }, propagateFromFunction: function () {
                                    return L;
                                }, boundValueFunction   : function () {
                                    return V;
                                }, checkForgottenReturns: function (t, e, n, r, i) {
                                    if ( void 0 === t && null !== e && j ) {
                                        if ( void 0 !== i && i._returnedNonUndefined() ) return;
                                        if ( 0 === (65535 & r._bitField) ) return;
                                        n && (n += ' ');
                                        var o = '', s = '';
                                        if ( e._trace ) {
                                            for (var a = e._trace.stack.split('\n'), c = q(a), u = c.length - 1; u >= 0; -- u) {
                                                var l = c[u];
                                                if ( ! _.test(l) ) {
                                                    var f = l.match(v);
                                                    f && (o = 'at ' + f[1] + ':' + f[2] + ':' + f[3] + ' ');
                                                    break;
                                                }
                                            }
                                            if ( c.length > 0 ) {
                                                var p = c[0];
                                                for (u = 0; u < a.length; ++ u) if ( a[u] === p ) {
                                                    u > 0 && (s = '\n' + a[u - 1]);
                                                    break;
                                                }
                                            }
                                        }
                                        var h = 'a promise was created in a ' + n + 'handler ' + o + 'but was not returned from it, see http://goo.gl/rRqMUw' + s;
                                        r._warn(h, ! 0, e);
                                    }
                                }, setBounds            : function (t, e) {
                                    if ( X() ) {
                                        for (var n, r, i = t.stack.split('\n'), o = e.stack.split('\n'), s = - 1, a = - 1, c = 0; c < i.length; ++ c) if ( u = K(i[c]) ) {
                                            n = u.fileName, s = u.line;
                                            break;
                                        }
                                        for (c = 0; c < o.length; ++ c) {
                                            var u;
                                            if ( u = K(o[c]) ) {
                                                r = u.fileName, a = u.line;
                                                break;
                                            }
                                        }
                                        s < 0 || a < 0 || ! n || ! r || n !== r || s >= a || (W = function (t) {
                                            if ( d.test(t) ) return ! 0;
                                            var e = K(t);
                                            return ! ! (e && e.fileName === n && s <= e.line && e.line <= a);
                                        });
                                    }
                                }, warn                 : H, deprecated: function (t, e) {
                                    var n = t + ' is deprecated and will be removed in a future version.';
                                    return e && (n += ' Use ' + e + ' instead.'), H(n);
                                }, CapturedTrace        : Z, fireDomEvent: k, fireGlobalEvent: E
                            };
                        };
                    }, {'./errors': 12, './es5': 13, './util': 36}], 10                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               : [function (t, e, n) {
                        'use strict';
                        e.exports = function (t) {
                            function e() {
                                return this.value;
                            }

                            function n() {
                                throw this.reason;
                            }

                            t.prototype.return = t.prototype.thenReturn = function (n) {
                                return n instanceof t && n.suppressUnhandledRejections(), this._then(e, void 0, void 0, {value: n}, void 0);
                            }, t.prototype.throw = t.prototype.thenThrow = function (t) {
                                return this._then(n, void 0, void 0, {reason: t}, void 0);
                            }, t.prototype.catchThrow = function (t) {
                                if ( arguments.length <= 1 ) return this._then(void 0, n, void 0, {reason: t}, void 0);
                                var e = arguments[1];
                                return this.caught(t, function () {
                                    throw e;
                                });
                            }, t.prototype.catchReturn = function (n) {
                                if ( arguments.length <= 1 ) return n instanceof t && n.suppressUnhandledRejections(), this._then(void 0, e, void 0, {value: n}, void 0);
                                var r = arguments[1];
                                r instanceof t && r.suppressUnhandledRejections();
                                return this.caught(n, function () {
                                    return r;
                                });
                            };
                        };
                    }, {}], 11                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        : [function (t, e, n) {
                        'use strict';
                        e.exports = function (t, e) {
                            var n = t.reduce, r = t.all;

                            function i() {
                                return r(this);
                            }

                            t.prototype.each = function (t) {
                                return n(this, t, e, 0)._then(i, void 0, void 0, this, void 0);
                            }, t.prototype.mapSeries = function (t) {
                                return n(this, t, e, e);
                            }, t.each = function (t, r) {
                                return n(t, r, e, 0)._then(i, void 0, void 0, t, void 0);
                            }, t.mapSeries = function (t, r) {
                                return n(t, r, e, e);
                            };
                        };
                    }, {}], 12                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        : [function (t, e, n) {
                        'use strict';
                        var r, o, s = t('./es5'), a = s.freeze, c = t('./util'), u = c.inherits, l = c.notEnumerableProp;

                        function f(t, e) {
                            function n(r) {
                                if ( ! (this instanceof n) ) return new n(r);
                                l(this, 'message', 'string' === typeof r ? r : e), l(this, 'name', t), Error.captureStackTrace ? Error.captureStackTrace(this, this.constructor) : Error.call(this);
                            }

                            return u(n, Error), n;
                        }

                        var p = f('Warning', 'warning'), h = f('CancellationError', 'cancellation error'), d = f('TimeoutError', 'timeout error'), _ = f('AggregateError', 'aggregate error');
                        try {
                            r = TypeError, o = RangeError;
                        } catch (i) {
                            r = f('TypeError', 'type error'), o = f('RangeError', 'range error');
                        }
                        for (var v = 'join pop push shift unshift slice filter forEach some every map indexOf lastIndexOf reduce reduceRight sort reverse'.split(' '), y = 0; y < v.length; ++ y) 'function' === typeof Array.prototype[v[y]] && (_.prototype[v[y]] = Array.prototype[v[y]]);
                        s.defineProperty(_.prototype, 'length', {value: 0, configurable: ! 1, writable: ! 0, enumerable: ! 0}), _.prototype.isOperational = ! 0;
                        var m = 0;

                        function g(t) {
                            if ( ! (this instanceof g) ) return new g(t);
                            l(this, 'name', 'OperationalError'), l(this, 'message', t), this.cause = t, this.isOperational = ! 0, t instanceof Error ? (l(this, 'message', t.message), l(this, 'stack', t.stack)) : Error.captureStackTrace && Error.captureStackTrace(this, this.constructor);
                        }

                        _.prototype.toString = function () {
                            var t = Array(4 * m + 1).join(' '), e = '\n' + t + 'AggregateError of:\n';
                            m ++, t = Array(4 * m + 1).join(' ');
                            for (var n = 0; n < this.length; ++ n) {
                                for (var r = this[n] === this ? '[Circular AggregateError]' : this[n] + '', i = r.split('\n'), o = 0; o < i.length; ++ o) i[o] = t + i[o];
                                e += (r = i.join('\n')) + '\n';
                            }
                            return m --, e;
                        }, u(g, Error);
                        var b = Error.__BluebirdErrorTypes__;
                        b || (b = a({CancellationError: h, TimeoutError: d, OperationalError: g, RejectionError: g, AggregateError: _}), s.defineProperty(Error, '__BluebirdErrorTypes__', {value: b, writable: ! 1, enumerable: ! 1, configurable: ! 1})), e.exports = {Error: Error, TypeError: r, RangeError: o, CancellationError: b.CancellationError, OperationalError: b.OperationalError, TimeoutError: b.TimeoutError, AggregateError: b.AggregateError, Warning: p};
                    }, {'./es5': 13, './util': 36}], 13                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               : [function (t, e, n) {
                        var r = function () {
                            'use strict';
                            return void 0 === this;
                        }();
                        if ( r ) e.exports = {
                            freeze: Object.freeze, defineProperty: Object.defineProperty, getDescriptor: Object.getOwnPropertyDescriptor, keys: Object.keys, names: Object.getOwnPropertyNames, getPrototypeOf: Object.getPrototypeOf, isArray: Array.isArray, isES5: r, propertyIsWritable: function (t, e) {
                                var n = Object.getOwnPropertyDescriptor(t, e);
                                return ! (n && ! n.writable && ! n.set);
                            }
                        }; else {
                            var o = {}.hasOwnProperty, s = {}.toString, a = {}.constructor.prototype, c = function (t) {
                                var e = [];
                                for (var n in t) o.call(t, n) && e.push(n);
                                return e;
                            };
                            e.exports = {
                                isArray          : function (t) {
                                    try {
                                        return '[object Array]' === s.call(t);
                                    } catch (i) {
                                        return ! 1;
                                    }
                                }, keys          : c, names: c, defineProperty: function (t, e, n) {
                                    return t[e] = n.value, t;
                                }, getDescriptor : function (t, e) {
                                    return {value: t[e]};
                                }, freeze        : function (t) {
                                    return t;
                                }, getPrototypeOf: function (t) {
                                    try {
                                        return Object(t).constructor.prototype;
                                    } catch (i) {
                                        return a;
                                    }
                                }, isES5         : r, propertyIsWritable: function () {
                                    return ! 0;
                                }
                            };
                        }
                    }, {}], 14                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        : [function (t, e, n) {
                        'use strict';
                        e.exports = function (t, e) {
                            var n = t.map;
                            t.prototype.filter = function (t, r) {
                                return n(this, t, r, e);
                            }, t.filter = function (t, r, i) {
                                return n(t, r, i, e);
                            };
                        };
                    }, {}], 15                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r) {
                            var i = t('./util'), o = e.CancellationError, s = i.errorObj, a = t('./catch_filter')(r);

                            function c(t, e, n) {
                                this.promise = t, this.type = e, this.handler = n, this.called = ! 1, this.cancelPromise = null;
                            }

                            function u(t) {
                                this.finallyHandler = t;
                            }

                            function l(t, e) {
                                return null != t.cancelPromise && (arguments.length > 1 ? t.cancelPromise._reject(e) : t.cancelPromise._cancel(), t.cancelPromise = null, ! 0);
                            }

                            function f() {
                                return h.call(this, this.promise._target()._settledValue());
                            }

                            function p(t) {
                                if ( ! l(this, t) ) return s.e = t, s;
                            }

                            function h(t) {
                                var i = this.promise, a = this.handler;
                                if ( ! this.called ) {
                                    this.called = ! 0;
                                    var c = this.isFinallyHandler() ? a.call(i._boundValue()) : a.call(i._boundValue(), t);
                                    if ( c === r ) return c;
                                    if ( void 0 !== c ) {
                                        i._setReturnedNonUndefined();
                                        var h = n(c, i);
                                        if ( h instanceof e ) {
                                            if ( null != this.cancelPromise ) {
                                                if ( h._isCancelled() ) {
                                                    var d = new o('late cancellation observer');
                                                    return i._attachExtraTrace(d), s.e = d, s;
                                                }
                                                h.isPending() && h._attachCancellationCallback(new u(this));
                                            }
                                            return h._then(f, p, void 0, this, void 0);
                                        }
                                    }
                                }
                                return i.isRejected() ? (l(this), s.e = t, s) : (l(this), t);
                            }

                            return c.prototype.isFinallyHandler = function () {
                                return 0 === this.type;
                            }, u.prototype._resultCancelled = function () {
                                l(this.finallyHandler);
                            }, e.prototype._passThrough = function (t, e, n, r) {
                                return 'function' !== typeof t ? this.then() : this._then(n, r, void 0, new c(this, e, t), void 0);
                            }, e.prototype.lastly = e.prototype.finally = function (t) {
                                return this._passThrough(t, 0, h, h);
                            }, e.prototype.tap = function (t) {
                                return this._passThrough(t, 1, h);
                            }, e.prototype.tapCatch = function (t) {
                                var n = arguments.length;
                                if ( 1 === n ) return this._passThrough(t, 1, void 0, h);
                                var r, o = new Array(n - 1), s = 0;
                                for (r = 0; r < n - 1; ++ r) {
                                    var c = arguments[r];
                                    if ( ! i.isObject(c) ) return e.reject(new TypeError('tapCatch statement predicate: expecting an object but got ' + i.classString(c)));
                                    o[s ++] = c;
                                }
                                o.length = s;
                                var u = arguments[r];
                                return this._passThrough(a(o, u, this), 1, void 0, h);
                            }, c;
                        };
                    }, {'./catch_filter': 7, './util': 36}], 16                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, i, o, s) {
                            var a = t('./errors').TypeError, c = t('./util'), u = c.errorObj, l = c.tryCatch, f = [];

                            function p(t, n, i, o) {
                                if ( s.cancellation() ) {
                                    var a = new e(r), c = this._finallyPromise = new e(r);
                                    this._promise = a.lastly(function () {
                                        return c;
                                    }), a._captureStackTrace(), a._setOnCancel(this);
                                } else {
                                    (this._promise = new e(r))._captureStackTrace();
                                }
                                this._stack = o, this._generatorFunction = t, this._receiver = n, this._generator = void 0, this._yieldHandlers = 'function' === typeof i ? [i].concat(f) : f, this._yieldedPromise = null, this._cancellationPhase = ! 1;
                            }

                            c.inherits(p, o), p.prototype._isResolved = function () {
                                return null === this._promise;
                            }, p.prototype._cleanup = function () {
                                this._promise = this._generator = null, s.cancellation() && null !== this._finallyPromise && (this._finallyPromise._fulfill(), this._finallyPromise = null);
                            }, p.prototype._promiseCancelled = function () {
                                if ( ! this._isResolved() ) {
                                    var t;
                                    if ( 'undefined' !== typeof this._generator.return ) this._promise._pushContext(), t = l(this._generator.return).call(this._generator, void 0), this._promise._popContext(); else {
                                        var n = new e.CancellationError('generator .return() sentinel');
                                        e.coroutine.returnSentinel = n, this._promise._attachExtraTrace(n), this._promise._pushContext(), t = l(this._generator.throw).call(this._generator, n), this._promise._popContext();
                                    }
                                    this._cancellationPhase = ! 0, this._yieldedPromise = null, this._continue(t);
                                }
                            }, p.prototype._promiseFulfilled = function (t) {
                                this._yieldedPromise = null, this._promise._pushContext();
                                var e = l(this._generator.next).call(this._generator, t);
                                this._promise._popContext(), this._continue(e);
                            }, p.prototype._promiseRejected = function (t) {
                                this._yieldedPromise = null, this._promise._attachExtraTrace(t), this._promise._pushContext();
                                var e = l(this._generator.throw).call(this._generator, t);
                                this._promise._popContext(), this._continue(e);
                            }, p.prototype._resultCancelled = function () {
                                if ( this._yieldedPromise instanceof e ) {
                                    var t = this._yieldedPromise;
                                    this._yieldedPromise = null, t.cancel();
                                }
                            }, p.prototype.promise = function () {
                                return this._promise;
                            }, p.prototype._run = function () {
                                this._generator = this._generatorFunction.call(this._receiver), this._receiver = this._generatorFunction = void 0, this._promiseFulfilled(void 0);
                            }, p.prototype._continue = function (t) {
                                var n = this._promise;
                                if ( t === u ) return this._cleanup(), this._cancellationPhase ? n.cancel() : n._rejectCallback(t.e, ! 1);
                                var r = t.value;
                                if ( ! 0 === t.done ) return this._cleanup(), this._cancellationPhase ? n.cancel() : n._resolveCallback(r);
                                var o = i(r, this._promise);
                                if ( o instanceof e || null !== (o = function (t, n, r) {
                                    for (var o = 0; o < n.length; ++ o) {
                                        r._pushContext();
                                        var s = l(n[o])(t);
                                        if ( r._popContext(), s === u ) {
                                            r._pushContext();
                                            var a = e.reject(u.e);
                                            return r._popContext(), a;
                                        }
                                        var c = i(s, r);
                                        if ( c instanceof e ) return c;
                                    }
                                    return null;
                                }(o, this._yieldHandlers, this._promise)) ) {
                                    var s = (o = o._target())._bitField;
                                    0 === (50397184 & s) ? (this._yieldedPromise = o, o._proxy(this, null)) : 0 !== (33554432 & s) ? e._async.invoke(this._promiseFulfilled, this, o._value()) : 0 !== (16777216 & s) ? e._async.invoke(this._promiseRejected, this, o._reason()) : this._promiseCancelled();
                                } else this._promiseRejected(new a('A value %s was yielded that could not be treated as a promise\n\n    See http://goo.gl/MqrFmX\n\n'.replace('%s', String(r)) + 'From coroutine:\n' + this._stack.split('\n').slice(1, - 7).join('\n')));
                            }, e.coroutine = function (t, e) {
                                if ( 'function' !== typeof t ) throw new a('generatorFunction must be a function\n\n    See http://goo.gl/MqrFmX\n');
                                var n = Object(e).yieldHandler, r = p, i = (new Error).stack;
                                return function () {
                                    var e = t.apply(this, arguments), o = new r(void 0, void 0, n, i), s = o.promise();
                                    return o._generator = e, o._promiseFulfilled(void 0), s;
                                };
                            }, e.coroutine.addYieldHandler = function (t) {
                                if ( 'function' !== typeof t ) throw new a('expecting a function but got ' + c.classString(t));
                                f.push(t);
                            }, e.spawn = function (t) {
                                if ( s.deprecated('Promise.spawn()', 'Promise.coroutine()'), 'function' !== typeof t ) return n('generatorFunction must be a function\n\n    See http://goo.gl/MqrFmX\n');
                                var r = new p(t, this), i = r.promise();
                                return r._run(e.spawn), i;
                            };
                        };
                    }, {'./errors': 12, './util': 36}], 17                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, i, o, s) {
                            var a = t('./util');
                            a.canEvaluate, a.tryCatch, a.errorObj;
                            e.join = function () {
                                var t, e = arguments.length - 1;
                                e > 0 && 'function' === typeof arguments[e] && (t = arguments[e]);
                                var r = [].slice.call(arguments);
                                t && r.pop();
                                var i = new n(r).promise();
                                return void 0 !== t ? i.spread(t) : i;
                            };
                        };
                    }, {'./util': 36}], 18                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, i, o, s) {
                            var a = e._getDomain, c = t('./util'), u = c.tryCatch, l = c.errorObj, f = e._async;

                            function p(t, e, n, r) {
                                this.constructor$(t), this._promise._captureStackTrace();
                                var i = a();
                                this._callback = null === i ? e : c.domainBind(i, e), this._preservedValues = r === o ? new Array(this.length()) : null, this._limit = n, this._inFlight = 0, this._queue = [], f.invoke(this._asyncInit, this, void 0);
                            }

                            function h(t, n, i, o) {
                                if ( 'function' !== typeof n ) return r('expecting a function but got ' + c.classString(n));
                                var s = 0;
                                if ( void 0 !== i ) {
                                    if ( 'object' !== typeof i || null === i ) return e.reject(new TypeError('options argument must be an object but it is ' + c.classString(i)));
                                    if ( 'number' !== typeof i.concurrency ) return e.reject(new TypeError('\'concurrency\' must be a number but it is ' + c.classString(i.concurrency)));
                                    s = i.concurrency;
                                }
                                return new p(t, n, s = 'number' === typeof s && isFinite(s) && s >= 1 ? s : 0, o).promise();
                            }

                            c.inherits(p, n), p.prototype._asyncInit = function () {
                                this._init$(void 0, - 2);
                            }, p.prototype._init = function () {
                            }, p.prototype._promiseFulfilled = function (t, n) {
                                var r = this._values, o = this.length(), a = this._preservedValues, c = this._limit;
                                if ( n < 0 ) {
                                    if ( r[n = - 1 * n - 1] = t, c >= 1 && (this._inFlight --, this._drainQueue(), this._isResolved()) ) return ! 0;
                                } else {
                                    if ( c >= 1 && this._inFlight >= c ) return r[n] = t, this._queue.push(n), ! 1;
                                    null !== a && (a[n] = t);
                                    var f = this._promise, p = this._callback, h = f._boundValue();
                                    f._pushContext();
                                    var d = u(p).call(h, t, n, o), _ = f._popContext();
                                    if ( s.checkForgottenReturns(d, _, null !== a ? 'Promise.filter' : 'Promise.map', f), d === l ) return this._reject(d.e), ! 0;
                                    var v = i(d, this._promise);
                                    if ( v instanceof e ) {
                                        var y = (v = v._target())._bitField;
                                        if ( 0 === (50397184 & y) ) return c >= 1 && this._inFlight ++, r[n] = v, v._proxy(this, - 1 * (n + 1)), ! 1;
                                        if ( 0 === (33554432 & y) ) return 0 !== (16777216 & y) ? (this._reject(v._reason()), ! 0) : (this._cancel(), ! 0);
                                        d = v._value();
                                    }
                                    r[n] = d;
                                }
                                return ++ this._totalResolved >= o && (null !== a ? this._filter(r, a) : this._resolve(r), ! 0);
                            }, p.prototype._drainQueue = function () {
                                for (var t = this._queue, e = this._limit, n = this._values; t.length > 0 && this._inFlight < e;) {
                                    if ( this._isResolved() ) return;
                                    var r = t.pop();
                                    this._promiseFulfilled(n[r], r);
                                }
                            }, p.prototype._filter = function (t, e) {
                                for (var n = e.length, r = new Array(n), i = 0, o = 0; o < n; ++ o) t[o] && (r[i ++] = e[o]);
                                r.length = i, this._resolve(r);
                            }, p.prototype.preservedValues = function () {
                                return this._preservedValues;
                            }, e.prototype.map = function (t, e) {
                                return h(this, t, e, null);
                            }, e.map = function (t, e, n, r) {
                                return h(t, e, n, r);
                            };
                        };
                    }, {'./util': 36}], 19                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, i, o) {
                            var s = t('./util'), a = s.tryCatch;
                            e.method = function (t) {
                                if ( 'function' !== typeof t ) throw new e.TypeError('expecting a function but got ' + s.classString(t));
                                return function () {
                                    var r = new e(n);
                                    r._captureStackTrace(), r._pushContext();
                                    var i = a(t).apply(this, arguments), s = r._popContext();
                                    return o.checkForgottenReturns(i, s, 'Promise.method', r), r._resolveFromSyncValue(i), r;
                                };
                            }, e.attempt = e.try = function (t) {
                                if ( 'function' !== typeof t ) return i('expecting a function but got ' + s.classString(t));
                                var r, c = new e(n);
                                if ( c._captureStackTrace(), c._pushContext(), arguments.length > 1 ) {
                                    o.deprecated('calling Promise.try with more than 1 argument');
                                    var u = arguments[1], l = arguments[2];
                                    r = s.isArray(u) ? a(t).apply(l, u) : a(t).call(l, u);
                                } else r = a(t)();
                                var f = c._popContext();
                                return o.checkForgottenReturns(r, f, 'Promise.try', c), c._resolveFromSyncValue(r), c;
                            }, e.prototype._resolveFromSyncValue = function (t) {
                                t === s.errorObj ? this._rejectCallback(t.e, ! 1) : this._resolveCallback(t, ! 0);
                            };
                        };
                    }, {'./util': 36}], 20                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        var r = t('./util'), i = r.maybeWrapAsError, o = t('./errors').OperationalError, s = t('./es5');
                        var a = /^(?:name|message|stack|cause)$/;

                        function c(t) {
                            var e;
                            if ( function (t) {
                                return t instanceof Error && s.getPrototypeOf(t) === Error.prototype;
                            }(t) ) {
                                (e = new o(t)).name = t.name, e.message = t.message, e.stack = t.stack;
                                for (var n = s.keys(t), i = 0; i < n.length; ++ i) {
                                    var c = n[i];
                                    a.test(c) || (e[c] = t[c]);
                                }
                                return e;
                            }
                            return r.markAsOriginatingFromRejection(t), t;
                        }

                        e.exports = function (t, e) {
                            return function (n, r) {
                                if ( null !== t ) {
                                    if ( n ) {
                                        var o = c(i(n));
                                        t._attachExtraTrace(o), t._reject(o);
                                    } else if ( e ) {
                                        var s = [].slice.call(arguments, 1);
                                        t._fulfill(s);
                                    } else t._fulfill(r);
                                    t = null;
                                }
                            };
                        };
                    }, {'./errors': 12, './es5': 13, './util': 36}], 21                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e) {
                            var n = t('./util'), r = e._async, i = n.tryCatch, o = n.errorObj;

                            function s(t, e) {
                                if ( ! n.isArray(t) ) return a.call(this, t, e);
                                var s = i(e).apply(this._boundValue(), [null].concat(t));
                                s === o && r.throwLater(s.e);
                            }

                            function a(t, e) {
                                var n = this._boundValue(), s = void 0 === t ? i(e).call(n, null) : i(e).call(n, null, t);
                                s === o && r.throwLater(s.e);
                            }

                            function c(t, e) {
                                if ( ! t ) {
                                    var n = new Error(t + '');
                                    n.cause = t, t = n;
                                }
                                var s = i(e).call(this._boundValue(), t);
                                s === o && r.throwLater(s.e);
                            }

                            e.prototype.asCallback = e.prototype.nodeify = function (t, e) {
                                if ( 'function' == typeof t ) {
                                    var n = a;
                                    void 0 !== e && Object(e).spread && (n = s), this._then(n, c, void 0, this, t);
                                }
                                return this;
                            };
                        };
                    }, {'./util': 36}], 22                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, n, r) {
                        'use strict';
                        n.exports = function () {
                            var r = function () {
                                return new d('circular promise resolution chain\n\n    See http://goo.gl/MqrFmX\n');
                            }, i  = function () {
                                return new P.PromiseInspection(this._target());
                            }, o  = function (t) {
                                return P.reject(new d(t));
                            };

                            function s() {
                            }

                            var a, c = {}, u = t('./util');
                            a = u.isNode ? function () {
                                var t = e.domain;
                                return void 0 === t && (t = null), t;
                            } : function () {
                                return null;
                            }, u.notEnumerableProp(P, '_getDomain', a);
                            var l = t('./es5'), f = t('./async'), p = new f;
                            l.defineProperty(P, '_async', {value: p});
                            var h = t('./errors'), d = P.TypeError = h.TypeError;
                            P.RangeError = h.RangeError;
                            var _ = P.CancellationError = h.CancellationError;
                            P.TimeoutError = h.TimeoutError, P.OperationalError = h.OperationalError, P.RejectionError = h.OperationalError, P.AggregateError = h.AggregateError;
                            var v = function () {
                            }, y  = {}, m = {}, g = t('./thenables')(P, v), b = t('./promise_array')(P, v, g, o, s), C = t('./context')(P), w = C.create, j = t('./debuggability')(P, C), F = (j.CapturedTrace, t('./finally')(P, g, m)), k = t('./catch_filter')(m), E = t('./nodeback'), x = u.errorObj, T = u.tryCatch;

                            function P(t) {
                                t !== v && function (t, e) {
                                    if ( null == t || t.constructor !== P ) throw new d('the promise constructor cannot be invoked directly\n\n    See http://goo.gl/MqrFmX\n');
                                    if ( 'function' !== typeof e ) throw new d('expecting a function but got ' + u.classString(e));
                                }(this, t), this._bitField = 0, this._fulfillmentHandler0 = void 0, this._rejectionHandler0 = void 0, this._promise0 = void 0, this._receiver0 = void 0, this._resolveFromExecutor(t), this._promiseCreated(), this._fireEvent('promiseCreated', this);
                            }

                            function O(t) {
                                this.promise._resolveCallback(t);
                            }

                            function S(t) {
                                this.promise._rejectCallback(t, ! 1);
                            }

                            function R(t) {
                                var e = new P(v);
                                e._fulfillmentHandler0 = t, e._rejectionHandler0 = t, e._promise0 = t, e._receiver0 = t;
                            }

                            return P.prototype.toString = function () {
                                return '[object Promise]';
                            }, P.prototype.caught = P.prototype.catch = function (t) {
                                var e = arguments.length;
                                if ( e > 1 ) {
                                    var n, r = new Array(e - 1), i = 0;
                                    for (n = 0; n < e - 1; ++ n) {
                                        var s = arguments[n];
                                        if ( ! u.isObject(s) ) return o('Catch statement predicate: expecting an object but got ' + u.classString(s));
                                        r[i ++] = s;
                                    }
                                    return r.length = i, t = arguments[n], this.then(void 0, k(r, t, this));
                                }
                                return this.then(void 0, t);
                            }, P.prototype.reflect = function () {
                                return this._then(i, i, void 0, this, void 0);
                            }, P.prototype.then = function (t, e) {
                                if ( j.warnings() && arguments.length > 0 && 'function' !== typeof t && 'function' !== typeof e ) {
                                    var n = '.then() only accepts functions but was passed: ' + u.classString(t);
                                    arguments.length > 1 && (n += ', ' + u.classString(e)), this._warn(n);
                                }
                                return this._then(t, e, void 0, void 0, void 0);
                            }, P.prototype.done = function (t, e) {
                                this._then(t, e, void 0, void 0, void 0)._setIsFinal();
                            }, P.prototype.spread = function (t) {
                                return 'function' !== typeof t ? o('expecting a function but got ' + u.classString(t)) : this.all()._then(t, void 0, void 0, y, void 0);
                            }, P.prototype.toJSON = function () {
                                var t = {isFulfilled: ! 1, isRejected: ! 1, fulfillmentValue: void 0, rejectionReason: void 0};
                                return this.isFulfilled() ? (t.fulfillmentValue = this.value(), t.isFulfilled = ! 0) : this.isRejected() && (t.rejectionReason = this.reason(), t.isRejected = ! 0), t;
                            }, P.prototype.all = function () {
                                return arguments.length > 0 && this._warn('.all() was passed arguments but it does not take any'), new b(this).promise();
                            }, P.prototype.error = function (t) {
                                return this.caught(u.originatesFromRejection, t);
                            }, P.getNewLibraryCopy = n.exports, P.is = function (t) {
                                return t instanceof P;
                            }, P.fromNode = P.fromCallback = function (t) {
                                var e = new P(v);
                                e._captureStackTrace();
                                var n = arguments.length > 1 && ! ! Object(arguments[1]).multiArgs, r = T(t)(E(e, n));
                                return r === x && e._rejectCallback(r.e, ! 0), e._isFateSealed() || e._setAsyncGuaranteed(), e;
                            }, P.all = function (t) {
                                return new b(t).promise();
                            }, P.cast = function (t) {
                                var e = g(t);
                                return e instanceof P || ((e = new P(v))._captureStackTrace(), e._setFulfilled(), e._rejectionHandler0 = t), e;
                            }, P.resolve = P.fulfilled = P.cast, P.reject = P.rejected = function (t) {
                                var e = new P(v);
                                return e._captureStackTrace(), e._rejectCallback(t, ! 0), e;
                            }, P.setScheduler = function (t) {
                                if ( 'function' !== typeof t ) throw new d('expecting a function but got ' + u.classString(t));
                                return p.setScheduler(t);
                            }, P.prototype._then = function (t, e, n, r, i) {
                                var o = void 0 !== i, s = o ? i : new P(v), c = this._target(), l = c._bitField;
                                o || (s._propagateFrom(this, 3), s._captureStackTrace(), void 0 === r && 0 !== (2097152 & this._bitField) && (r = 0 !== (50397184 & l) ? this._boundValue() : c === this ? void 0 : this._boundTo), this._fireEvent('promiseChained', this, s));
                                var f = a();
                                if ( 0 !== (50397184 & l) ) {
                                    var h, d, y = c._settlePromiseCtx;
                                    0 !== (33554432 & l) ? (d = c._rejectionHandler0, h = t) : 0 !== (16777216 & l) ? (d = c._fulfillmentHandler0, h = e, c._unsetRejectionIsUnhandled()) : (y = c._settlePromiseLateCancellationObserver, d = new _('late cancellation observer'), c._attachExtraTrace(d), h = e), p.invoke(y, c, {handler: null === f ? h : 'function' === typeof h && u.domainBind(f, h), promise: s, receiver: r, value: d});
                                } else c._addCallbacks(t, e, s, r, f);
                                return s;
                            }, P.prototype._length = function () {
                                return 65535 & this._bitField;
                            }, P.prototype._isFateSealed = function () {
                                return 0 !== (117506048 & this._bitField);
                            }, P.prototype._isFollowing = function () {
                                return 67108864 === (67108864 & this._bitField);
                            }, P.prototype._setLength = function (t) {
                                this._bitField = - 65536 & this._bitField | 65535 & t;
                            }, P.prototype._setFulfilled = function () {
                                this._bitField = 33554432 | this._bitField, this._fireEvent('promiseFulfilled', this);
                            }, P.prototype._setRejected = function () {
                                this._bitField = 16777216 | this._bitField, this._fireEvent('promiseRejected', this);
                            }, P.prototype._setFollowing = function () {
                                this._bitField = 67108864 | this._bitField, this._fireEvent('promiseResolved', this);
                            }, P.prototype._setIsFinal = function () {
                                this._bitField = 4194304 | this._bitField;
                            }, P.prototype._isFinal = function () {
                                return (4194304 & this._bitField) > 0;
                            }, P.prototype._unsetCancelled = function () {
                                this._bitField = - 65537 & this._bitField;
                            }, P.prototype._setCancelled = function () {
                                this._bitField = 65536 | this._bitField, this._fireEvent('promiseCancelled', this);
                            }, P.prototype._setWillBeCancelled = function () {
                                this._bitField = 8388608 | this._bitField;
                            }, P.prototype._setAsyncGuaranteed = function () {
                                p.hasCustomScheduler() || (this._bitField = 134217728 | this._bitField);
                            }, P.prototype._receiverAt = function (t) {
                                var e = 0 === t ? this._receiver0 : this[4 * t - 4 + 3];
                                if ( e !== c ) return void 0 === e && this._isBound() ? this._boundValue() : e;
                            }, P.prototype._promiseAt = function (t) {
                                return this[4 * t - 4 + 2];
                            }, P.prototype._fulfillmentHandlerAt = function (t) {
                                return this[4 * t - 4 + 0];
                            }, P.prototype._rejectionHandlerAt = function (t) {
                                return this[4 * t - 4 + 1];
                            }, P.prototype._boundValue = function () {
                            }, P.prototype._migrateCallback0 = function (t) {
                                t._bitField;
                                var e = t._fulfillmentHandler0, n = t._rejectionHandler0, r = t._promise0, i = t._receiverAt(0);
                                void 0 === i && (i = c), this._addCallbacks(e, n, r, i, null);
                            }, P.prototype._migrateCallbackAt = function (t, e) {
                                var n = t._fulfillmentHandlerAt(e), r = t._rejectionHandlerAt(e), i = t._promiseAt(e), o = t._receiverAt(e);
                                void 0 === o && (o = c), this._addCallbacks(n, r, i, o, null);
                            }, P.prototype._addCallbacks = function (t, e, n, r, i) {
                                var o = this._length();
                                if ( o >= 65531 && (o = 0, this._setLength(0)), 0 === o ) this._promise0 = n, this._receiver0 = r, 'function' === typeof t && (this._fulfillmentHandler0 = null === i ? t : u.domainBind(i, t)), 'function' === typeof e && (this._rejectionHandler0 = null === i ? e : u.domainBind(i, e)); else {
                                    var s = 4 * o - 4;
                                    this[s + 2] = n, this[s + 3] = r, 'function' === typeof t && (this[s + 0] = null === i ? t : u.domainBind(i, t)), 'function' === typeof e && (this[s + 1] = null === i ? e : u.domainBind(i, e));
                                }
                                return this._setLength(o + 1), o;
                            }, P.prototype._proxy = function (t, e) {
                                this._addCallbacks(void 0, void 0, e, t, null);
                            }, P.prototype._resolveCallback = function (t, e) {
                                if ( 0 === (117506048 & this._bitField) ) {
                                    if ( t === this ) return this._rejectCallback(r(), ! 1);
                                    var n = g(t, this);
                                    if ( ! (n instanceof P) ) return this._fulfill(t);
                                    e && this._propagateFrom(n, 2);
                                    var i = n._target();
                                    if ( i !== this ) {
                                        var o = i._bitField;
                                        if ( 0 === (50397184 & o) ) {
                                            var s = this._length();
                                            s > 0 && i._migrateCallback0(this);
                                            for (var a = 1; a < s; ++ a) i._migrateCallbackAt(this, a);
                                            this._setFollowing(), this._setLength(0), this._setFollowee(i);
                                        } else if ( 0 !== (33554432 & o) ) this._fulfill(i._value()); else if ( 0 !== (16777216 & o) ) this._reject(i._reason()); else {
                                            var c = new _('late cancellation observer');
                                            i._attachExtraTrace(c), this._reject(c);
                                        }
                                    } else this._reject(r());
                                }
                            }, P.prototype._rejectCallback = function (t, e, n) {
                                var r = u.ensureErrorObject(t), i = r === t;
                                if ( ! i && ! n && j.warnings() ) {
                                    var o = 'a promise was rejected with a non-error: ' + u.classString(t);
                                    this._warn(o, ! 0);
                                }
                                this._attachExtraTrace(r, ! ! e && i), this._reject(t);
                            }, P.prototype._resolveFromExecutor = function (t) {
                                if ( t !== v ) {
                                    var e = this;
                                    this._captureStackTrace(), this._pushContext();
                                    var n = ! 0, r = this._execute(t, function (t) {
                                        e._resolveCallback(t);
                                    }, function (t) {
                                        e._rejectCallback(t, n);
                                    });
                                    n = ! 1, this._popContext(), void 0 !== r && e._rejectCallback(r, ! 0);
                                }
                            }, P.prototype._settlePromiseFromHandler = function (t, e, n, r) {
                                var i = r._bitField;
                                if ( 0 === (65536 & i) ) {
                                    var o;
                                    r._pushContext(), e === y ? n && 'number' === typeof n.length ? o = T(t).apply(this._boundValue(), n) : (o = x).e = new d('cannot .spread() a non-array: ' + u.classString(n)) : o = T(t).call(e, n);
                                    var s = r._popContext();
                                    0 === (65536 & (i = r._bitField)) && (o === m ? r._reject(n) : o === x ? r._rejectCallback(o.e, ! 1) : (j.checkForgottenReturns(o, s, '', r, this), r._resolveCallback(o)));
                                }
                            }, P.prototype._target = function () {
                                for (var t = this; t._isFollowing();) t = t._followee();
                                return t;
                            }, P.prototype._followee = function () {
                                return this._rejectionHandler0;
                            }, P.prototype._setFollowee = function (t) {
                                this._rejectionHandler0 = t;
                            }, P.prototype._settlePromise = function (t, e, n, r) {
                                var o = t instanceof P, a = this._bitField, c = 0 !== (134217728 & a);
                                0 !== (65536 & a) ? (o && t._invokeInternalOnCancel(), n instanceof F && n.isFinallyHandler() ? (n.cancelPromise = t, T(e).call(n, r) === x && t._reject(x.e)) : e === i ? t._fulfill(i.call(n)) : n instanceof s ? n._promiseCancelled(t) : o || t instanceof b ? t._cancel() : n.cancel()) : 'function' === typeof e ? o ? (c && t._setAsyncGuaranteed(), this._settlePromiseFromHandler(e, n, r, t)) : e.call(n, r, t) : n instanceof s ? n._isResolved() || (0 !== (33554432 & a) ? n._promiseFulfilled(r, t) : n._promiseRejected(r, t)) : o && (c && t._setAsyncGuaranteed(), 0 !== (33554432 & a) ? t._fulfill(r) : t._reject(r));
                            }, P.prototype._settlePromiseLateCancellationObserver = function (t) {
                                var e = t.handler, n = t.promise, r = t.receiver, i = t.value;
                                'function' === typeof e ? n instanceof P ? this._settlePromiseFromHandler(e, r, i, n) : e.call(r, i, n) : n instanceof P && n._reject(i);
                            }, P.prototype._settlePromiseCtx = function (t) {
                                this._settlePromise(t.promise, t.handler, t.receiver, t.value);
                            }, P.prototype._settlePromise0 = function (t, e, n) {
                                var r = this._promise0, i = this._receiverAt(0);
                                this._promise0 = void 0, this._receiver0 = void 0, this._settlePromise(r, t, i, e);
                            }, P.prototype._clearCallbackDataAtIndex = function (t) {
                                var e = 4 * t - 4;
                                this[e + 2] = this[e + 3] = this[e + 0] = this[e + 1] = void 0;
                            }, P.prototype._fulfill = function (t) {
                                var e = this._bitField;
                                if ( ! ((117506048 & e) >>> 16) ) {
                                    if ( t === this ) {
                                        var n = r();
                                        return this._attachExtraTrace(n), this._reject(n);
                                    }
                                    this._setFulfilled(), this._rejectionHandler0 = t, (65535 & e) > 0 && (0 !== (134217728 & e) ? this._settlePromises() : p.settlePromises(this), this._dereferenceTrace());
                                }
                            }, P.prototype._reject = function (t) {
                                var e = this._bitField;
                                if ( ! ((117506048 & e) >>> 16) ) {
                                    if ( this._setRejected(), this._fulfillmentHandler0 = t, this._isFinal() ) return p.fatalError(t, u.isNode);
                                    (65535 & e) > 0 ? p.settlePromises(this) : this._ensurePossibleRejectionHandled();
                                }
                            }, P.prototype._fulfillPromises = function (t, e) {
                                for (var n = 1; n < t; n ++) {
                                    var r = this._fulfillmentHandlerAt(n), i = this._promiseAt(n), o = this._receiverAt(n);
                                    this._clearCallbackDataAtIndex(n), this._settlePromise(i, r, o, e);
                                }
                            }, P.prototype._rejectPromises = function (t, e) {
                                for (var n = 1; n < t; n ++) {
                                    var r = this._rejectionHandlerAt(n), i = this._promiseAt(n), o = this._receiverAt(n);
                                    this._clearCallbackDataAtIndex(n), this._settlePromise(i, r, o, e);
                                }
                            }, P.prototype._settlePromises = function () {
                                var t = this._bitField, e = 65535 & t;
                                if ( e > 0 ) {
                                    if ( 0 !== (16842752 & t) ) {
                                        var n = this._fulfillmentHandler0;
                                        this._settlePromise0(this._rejectionHandler0, n, t), this._rejectPromises(e, n);
                                    } else {
                                        var r = this._rejectionHandler0;
                                        this._settlePromise0(this._fulfillmentHandler0, r, t), this._fulfillPromises(e, r);
                                    }
                                    this._setLength(0);
                                }
                                this._clearCancellationData();
                            }, P.prototype._settledValue = function () {
                                var t = this._bitField;
                                return 0 !== (33554432 & t) ? this._rejectionHandler0 : 0 !== (16777216 & t) ? this._fulfillmentHandler0 : void 0;
                            }, P.defer = P.pending = function () {
                                return j.deprecated('Promise.defer', 'new Promise'), {promise: new P(v), resolve: O, reject: S};
                            }, u.notEnumerableProp(P, '_makeSelfResolutionError', r), t('./method')(P, v, g, o, j), t('./bind')(P, v, g, j), t('./cancel')(P, b, o, j), t('./direct_resolve')(P), t('./synchronous_inspection')(P), t('./join')(P, b, g, v, p, a), P.Promise = P, P.version = '3.5.3', t('./map.js')(P, b, o, g, v, j), t('./call_get.js')(P), t('./using.js')(P, o, g, w, v, j), t('./timers.js')(P, v, j), t('./generators.js')(P, o, v, g, s, j), t('./nodeify.js')(P), t('./promisify.js')(P, v), t('./props.js')(P, b, g, o), t('./race.js')(P, v, g, o), t('./reduce.js')(P, b, o, g, v, j), t('./settle.js')(P, b, j), t('./some.js')(P, b, o), t('./filter.js')(P, v), t('./each.js')(P, v), t('./any.js')(P), u.toFastProperties(P), u.toFastProperties(P.prototype), R({a: 1}), R({b: 2}), R({c: 3}), R(1), R(function () {
                            }), R(void 0), R(! 1), R(new P(v)), j.setBounds(f.firstLineError, u.lastLineError), P;
                        };
                    }, {'./any.js': 1, './async': 2, './bind': 3, './call_get.js': 5, './cancel': 6, './catch_filter': 7, './context': 8, './debuggability': 9, './direct_resolve': 10, './each.js': 11, './errors': 12, './es5': 13, './filter.js': 14, './finally': 15, './generators.js': 16, './join': 17, './map.js': 18, './method': 19, './nodeback': 20, './nodeify.js': 21, './promise_array': 23, './promisify.js': 24, './props.js': 25, './race.js': 27, './reduce.js': 28, './settle.js': 30, './some.js': 31, './synchronous_inspection': 32, './thenables': 33, './timers.js': 34, './using.js': 35, './util': 36}], 23: [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, i, o) {
                            var s = t('./util');
                            s.isArray;

                            function a(t) {
                                var r = this._promise = new e(n);
                                t instanceof e && r._propagateFrom(t, 3), r._setOnCancel(this), this._values = t, this._length = 0, this._totalResolved = 0, this._init(void 0, - 2);
                            }

                            return s.inherits(a, o), a.prototype.length = function () {
                                return this._length;
                            }, a.prototype.promise = function () {
                                return this._promise;
                            }, a.prototype._init = function t(n, o) {
                                var a = r(this._values, this._promise);
                                if ( a instanceof e ) {
                                    var c = (a = a._target())._bitField;
                                    if ( this._values = a, 0 === (50397184 & c) ) return this._promise._setAsyncGuaranteed(), a._then(t, this._reject, void 0, this, o);
                                    if ( 0 === (33554432 & c) ) return 0 !== (16777216 & c) ? this._reject(a._reason()) : this._cancel();
                                    a = a._value();
                                }
                                if ( null !== (a = s.asArray(a)) ) 0 !== a.length ? this._iterate(a) : - 5 === o ? this._resolveEmptyArray() : this._resolve(function (t) {
                                    switch (t) {
                                        case- 2:
                                            return [];
                                        case- 3:
                                            return {};
                                        case- 6:
                                            return new Map;
                                    }
                                }(o)); else {
                                    var u = i('expecting an array or an iterable object but got ' + s.classString(a)).reason();
                                    this._promise._rejectCallback(u, ! 1);
                                }
                            }, a.prototype._iterate = function (t) {
                                var n = this.getActualLength(t.length);
                                this._length = n, this._values = this.shouldCopyValues() ? new Array(n) : this._values;
                                for (var i = this._promise, o = ! 1, s = null, a = 0; a < n; ++ a) {
                                    var c = r(t[a], i);
                                    s = c instanceof e ? (c = c._target())._bitField : null, o ? null !== s && c.suppressUnhandledRejections() : null !== s ? 0 === (50397184 & s) ? (c._proxy(this, a), this._values[a] = c) : o = 0 !== (33554432 & s) ? this._promiseFulfilled(c._value(), a) : 0 !== (16777216 & s) ? this._promiseRejected(c._reason(), a) : this._promiseCancelled(a) : o = this._promiseFulfilled(c, a);
                                }
                                o || i._setAsyncGuaranteed();
                            }, a.prototype._isResolved = function () {
                                return null === this._values;
                            }, a.prototype._resolve = function (t) {
                                this._values = null, this._promise._fulfill(t);
                            }, a.prototype._cancel = function () {
                                ! this._isResolved() && this._promise._isCancellable() && (this._values = null, this._promise._cancel());
                            }, a.prototype._reject = function (t) {
                                this._values = null, this._promise._rejectCallback(t, ! 1);
                            }, a.prototype._promiseFulfilled = function (t, e) {
                                return this._values[e] = t, ++ this._totalResolved >= this._length && (this._resolve(this._values), ! 0);
                            }, a.prototype._promiseCancelled = function () {
                                return this._cancel(), ! 0;
                            }, a.prototype._promiseRejected = function (t) {
                                return this._totalResolved ++, this._reject(t), ! 0;
                            }, a.prototype._resultCancelled = function () {
                                if ( ! this._isResolved() ) {
                                    var t = this._values;
                                    if ( this._cancel(), t instanceof e ) t.cancel(); else for (var n = 0; n < t.length; ++ n) t[n] instanceof e && t[n].cancel();
                                }
                            }, a.prototype.shouldCopyValues = function () {
                                return ! 0;
                            }, a.prototype.getActualLength = function (t) {
                                return t;
                            }, a;
                        };
                    }, {'./util': 36}], 24                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n) {
                            var r = {}, o = t('./util'), s = t('./nodeback'), a = o.withAppended, c = o.maybeWrapAsError, u = o.canEvaluate, l = t('./errors').TypeError, f = {__isPromisified__: ! 0}, p = new RegExp('^(?:' + ['arity', 'length', 'name', 'arguments', 'caller', 'callee', 'prototype', '__isPromisified__'].join('|') + ')$'), h = function (t) {
                                return o.isIdentifier(t) && '_' !== t.charAt(0) && 'constructor' !== t;
                            };

                            function d(t) {
                                return ! p.test(t);
                            }

                            function _(t) {
                                try {
                                    return ! 0 === t.__isPromisified__;
                                } catch (i) {
                                    return ! 1;
                                }
                            }

                            function v(t, e, n) {
                                var r = o.getDataPropertyOrDefault(t, e + n, f);
                                return ! ! r && _(r);
                            }

                            function y(t, e, n, r) {
                                for (var i = o.inheritedDataKeys(t), s = [], a = 0; a < i.length; ++ a) {
                                    var c = i[a], u = t[c], f = r === h || h(c, u, t);
                                    'function' !== typeof u || _(u) || v(t, c, e) || ! r(c, u, t, f) || s.push(c, u);
                                }
                                return function (t, e, n) {
                                    for (var r = 0; r < t.length; r += 2) {
                                        var i = t[r];
                                        if ( n.test(i) ) for (var o = i.replace(n, ''), s = 0; s < t.length; s += 2) if ( t[s] === o ) throw new l('Cannot promisify an API that has normal methods with \'%s\'-suffix\n\n    See http://goo.gl/MqrFmX\n'.replace('%s', e));
                                    }
                                }(s, e, n), s;
                            }

                            var m = function (t) {
                                return t.replace(/([$])/, '\\$');
                            };
                            var g = u ? void 0 : function (t, u, l, f, p, h) {
                                var d  = function () {
                                    return this;
                                }(), _ = t;

                                function v() {
                                    var o = u;
                                    u === r && (o = this);
                                    var l = new e(n);
                                    l._captureStackTrace();
                                    var f = 'string' === typeof _ && this !== d ? this[_] : t, p = s(l, h);
                                    try {
                                        f.apply(o, a(arguments, p));
                                    } catch (i) {
                                        l._rejectCallback(c(i), ! 0, ! 0);
                                    }
                                    return l._isFateSealed() || l._setAsyncGuaranteed(), l;
                                }

                                return 'string' === typeof _ && (t = f), o.notEnumerableProp(v, '__isPromisified__', ! 0), v;
                            };

                            function b(t, e, n, i, s) {
                                for (var a = new RegExp(m(e) + '$'), c = y(t, e, a, n), u = 0, l = c.length; u < l; u += 2) {
                                    var f = c[u], p = c[u + 1], h = f + e;
                                    if ( i === g ) t[h] = g(f, r, f, p, e, s); else {
                                        var d = i(p, function () {
                                            return g(f, r, f, p, e, s);
                                        });
                                        o.notEnumerableProp(d, '__isPromisified__', ! 0), t[h] = d;
                                    }
                                }
                                return o.toFastProperties(t), t;
                            }

                            e.promisify = function (t, e) {
                                if ( 'function' !== typeof t ) throw new l('expecting a function but got ' + o.classString(t));
                                if ( _(t) ) return t;
                                var n = function (t, e, n) {
                                    return g(t, e, void 0, t, null, n);
                                }(t, void 0 === (e = Object(e)).context ? r : e.context, ! ! e.multiArgs);
                                return o.copyDescriptors(t, n, d), n;
                            }, e.promisifyAll = function (t, e) {
                                if ( 'function' !== typeof t && 'object' !== typeof t ) throw new l('the target of promisifyAll must be an object or a function\n\n    See http://goo.gl/MqrFmX\n');
                                var n = ! ! (e = Object(e)).multiArgs, r = e.suffix;
                                'string' !== typeof r && (r = 'Async');
                                var i = e.filter;
                                'function' !== typeof i && (i = h);
                                var s = e.promisifier;
                                if ( 'function' !== typeof s && (s = g), ! o.isIdentifier(r) ) throw new RangeError('suffix must be a valid identifier\n\n    See http://goo.gl/MqrFmX\n');
                                for (var a = o.inheritedDataKeys(t), c = 0; c < a.length; ++ c) {
                                    var u = t[a[c]];
                                    'constructor' !== a[c] && o.isClass(u) && (b(u.prototype, r, i, s, n), b(u, r, i, s, n));
                                }
                                return b(t, r, i, s, n);
                            };
                        };
                    }, {'./errors': 12, './nodeback': 20, './util': 36}], 25                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, i) {
                            var o, s = t('./util'), a = s.isObject, c = t('./es5');
                            'function' === typeof Map && (o = Map);
                            var u = function () {
                                var t = 0, e = 0;

                                function n(n, r) {
                                    this[t] = n, this[t + e] = r, t ++;
                                }

                                return function (r) {
                                    e = r.size, t = 0;
                                    var i = new Array(2 * r.size);
                                    return r.forEach(n, i), i;
                                };
                            }();

                            function l(t) {
                                var e, n = ! 1;
                                if ( void 0 !== o && t instanceof o ) e = u(t), n = ! 0; else {
                                    var r = c.keys(t), i = r.length;
                                    e = new Array(2 * i);
                                    for (var s = 0; s < i; ++ s) {
                                        var a = r[s];
                                        e[s] = t[a], e[s + i] = a;
                                    }
                                }
                                this.constructor$(e), this._isMap = n, this._init$(void 0, n ? - 6 : - 3);
                            }

                            function f(t) {
                                var n, o = r(t);
                                return a(o) ? (n = o instanceof e ? o._then(e.props, void 0, void 0, void 0, void 0) : new l(o).promise(), o instanceof e && n._propagateFrom(o, 2), n) : i('cannot await properties of a non-object\n\n    See http://goo.gl/MqrFmX\n');
                            }

                            s.inherits(l, n), l.prototype._init = function () {
                            }, l.prototype._promiseFulfilled = function (t, e) {
                                if ( this._values[e] = t, ++ this._totalResolved >= this._length ) {
                                    var n;
                                    if ( this._isMap ) n = function (t) {
                                        for (var e = new o, n = t.length / 2 | 0, r = 0; r < n; ++ r) {
                                            var i = t[n + r], s = t[r];
                                            e.set(i, s);
                                        }
                                        return e;
                                    }(this._values); else {
                                        n = {};
                                        for (var r = this.length(), i = 0, s = this.length(); i < s; ++ i) n[this._values[i + r]] = this._values[i];
                                    }
                                    return this._resolve(n), ! 0;
                                }
                                return ! 1;
                            }, l.prototype.shouldCopyValues = function () {
                                return ! 1;
                            }, l.prototype.getActualLength = function (t) {
                                return t >> 1;
                            }, e.prototype.props = function () {
                                return f(this);
                            }, e.props = function (t) {
                                return f(t);
                            };
                        };
                    }, {'./es5': 13, './util': 36}], 26                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               : [function (t, e, n) {
                        'use strict';

                        function r(t) {
                            this._capacity = t, this._length = 0, this._front = 0;
                        }

                        r.prototype._willBeOverCapacity = function (t) {
                            return this._capacity < t;
                        }, r.prototype._pushOne = function (t) {
                            var e = this.length();
                            this._checkCapacity(e + 1), this[this._front + e & this._capacity - 1] = t, this._length = e + 1;
                        }, r.prototype.push = function (t, e, n) {
                            var r = this.length() + 3;
                            if ( this._willBeOverCapacity(r) ) return this._pushOne(t), this._pushOne(e), void this._pushOne(n);
                            var i = this._front + r - 3;
                            this._checkCapacity(r);
                            var o = this._capacity - 1;
                            this[i + 0 & o] = t, this[i + 1 & o] = e, this[i + 2 & o] = n, this._length = r;
                        }, r.prototype.shift = function () {
                            var t = this._front, e = this[t];
                            return this[t] = void 0, this._front = t + 1 & this._capacity - 1, this._length --, e;
                        }, r.prototype.length = function () {
                            return this._length;
                        }, r.prototype._checkCapacity = function (t) {
                            this._capacity < t && this._resizeTo(this._capacity << 1);
                        }, r.prototype._resizeTo = function (t) {
                            var e = this._capacity;
                            this._capacity = t, function (t, e, n, r, i) {
                                for (var o = 0; o < i; ++ o) n[o + r] = t[o + e], t[o + e] = void 0;
                            }(this, 0, this, e, this._front + this._length & e - 1);
                        }, e.exports = r;
                    }, {}], 27                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, i) {
                            var o = t('./util'), s = function (t) {
                                return t.then(function (e) {
                                    return a(e, t);
                                });
                            };

                            function a(t, a) {
                                var c = r(t);
                                if ( c instanceof e ) return s(c);
                                if ( null === (t = o.asArray(t)) ) return i('expecting an array or an iterable object but got ' + o.classString(t));
                                var u = new e(n);
                                void 0 !== a && u._propagateFrom(a, 3);
                                for (var l = u._fulfill, f = u._reject, p = 0, h = t.length; p < h; ++ p) {
                                    var d = t[p];
                                    (void 0 !== d || p in t) && e.cast(d)._then(l, f, void 0, u, null);
                                }
                                return u;
                            }

                            e.race = function (t) {
                                return a(t, void 0);
                            }, e.prototype.race = function () {
                                return a(this, void 0);
                            };
                        };
                    }, {'./util': 36}], 28                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, i, o, s) {
                            var a = e._getDomain, c = t('./util'), u = c.tryCatch;

                            function l(t, n, r, i) {
                                this.constructor$(t);
                                var s = a();
                                this._fn = null === s ? n : c.domainBind(s, n), void 0 !== r && (r = e.resolve(r))._attachCancellationCallback(this), this._initialValue = r, this._currentCancellable = null, this._eachValues = i === o ? Array(this._length) : 0 === i ? null : void 0, this._promise._captureStackTrace(), this._init$(void 0, - 5);
                            }

                            function f(t, e) {
                                this.isFulfilled() ? e._resolve(t) : e._reject(t);
                            }

                            function p(t, e, n, i) {
                                return 'function' !== typeof e ? r('expecting a function but got ' + c.classString(e)) : new l(t, e, n, i).promise();
                            }

                            function h(t) {
                                this.accum = t, this.array._gotAccum(t);
                                var n = i(this.value, this.array._promise);
                                return n instanceof e ? (this.array._currentCancellable = n, n._then(d, void 0, void 0, this, void 0)) : d.call(this, n);
                            }

                            function d(t) {
                                var n, r = this.array, i = r._promise, o = u(r._fn);
                                i._pushContext(), (n = void 0 !== r._eachValues ? o.call(i._boundValue(), t, this.index, this.length) : o.call(i._boundValue(), this.accum, t, this.index, this.length)) instanceof e && (r._currentCancellable = n);
                                var a = i._popContext();
                                return s.checkForgottenReturns(n, a, void 0 !== r._eachValues ? 'Promise.each' : 'Promise.reduce', i), n;
                            }

                            c.inherits(l, n), l.prototype._gotAccum = function (t) {
                                void 0 !== this._eachValues && null !== this._eachValues && t !== o && this._eachValues.push(t);
                            }, l.prototype._eachComplete = function (t) {
                                return null !== this._eachValues && this._eachValues.push(t), this._eachValues;
                            }, l.prototype._init = function () {
                            }, l.prototype._resolveEmptyArray = function () {
                                this._resolve(void 0 !== this._eachValues ? this._eachValues : this._initialValue);
                            }, l.prototype.shouldCopyValues = function () {
                                return ! 1;
                            }, l.prototype._resolve = function (t) {
                                this._promise._resolveCallback(t), this._values = null;
                            }, l.prototype._resultCancelled = function (t) {
                                if ( t === this._initialValue ) return this._cancel();
                                this._isResolved() || (this._resultCancelled$(), this._currentCancellable instanceof e && this._currentCancellable.cancel(), this._initialValue instanceof e && this._initialValue.cancel());
                            }, l.prototype._iterate = function (t) {
                                var n, r;
                                this._values = t;
                                var i = t.length;
                                if ( void 0 !== this._initialValue ? (n = this._initialValue, r = 0) : (n = e.resolve(t[0]), r = 1), this._currentCancellable = n, ! n.isRejected() ) for (; r < i; ++ r) {
                                    var o = {accum: null, value: t[r], index: r, length: i, array: this};
                                    n = n._then(h, void 0, void 0, o, void 0);
                                }
                                void 0 !== this._eachValues && (n = n._then(this._eachComplete, void 0, void 0, this, void 0)), n._then(f, f, void 0, n, this);
                            }, e.prototype.reduce = function (t, e) {
                                return p(this, t, e, null);
                            }, e.reduce = function (t, e, n, r) {
                                return p(t, e, n, r);
                            };
                        };
                    }, {'./util': 36}], 29                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, i, o) {
                        'use strict';
                        var s, a = t('./util'), c = a.getNativePromise();
                        if ( a.isNode && 'undefined' === typeof MutationObserver ) {
                            var u = n.setImmediate, l = e.nextTick;
                            s = a.isRecentNode ? function (t) {
                                u.call(n, t);
                            } : function (t) {
                                l.call(e, t);
                            };
                        } else if ( 'function' === typeof c && 'function' === typeof c.resolve ) {
                            var f = c.resolve();
                            s = function (t) {
                                f.then(t);
                            };
                        } else s = 'undefined' === typeof MutationObserver || 'undefined' !== typeof window && window.navigator && (window.navigator.standalone || window.cordova) ? 'undefined' !== typeof r ? function (t) {
                            r(t);
                        } : 'undefined' !== typeof setTimeout ? function (t) {
                            setTimeout(t, 0);
                        } : function () {
                            throw new Error('No async scheduler available\n\n    See http://goo.gl/MqrFmX\n');
                        } : function () {
                            var t = document.createElement('div'), e = {attributes: ! 0}, n = ! 1, r = document.createElement('div');
                            new MutationObserver(function () {
                                t.classList.toggle('foo'), n = ! 1;
                            }).observe(r, e);
                            return function (i) {
                                var o = new MutationObserver(function () {
                                    o.disconnect(), i();
                                });
                                o.observe(t, e), n || (n = ! 0, r.classList.toggle('foo'));
                            };
                        }();
                        i.exports = s;
                    }, {'./util': 36}], 30                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r) {
                            var i = e.PromiseInspection;

                            function o(t) {
                                this.constructor$(t);
                            }

                            t('./util').inherits(o, n), o.prototype._promiseResolved = function (t, e) {
                                return this._values[t] = e, ++ this._totalResolved >= this._length && (this._resolve(this._values), ! 0);
                            }, o.prototype._promiseFulfilled = function (t, e) {
                                var n = new i;
                                return n._bitField = 33554432, n._settledValueField = t, this._promiseResolved(e, n);
                            }, o.prototype._promiseRejected = function (t, e) {
                                var n = new i;
                                return n._bitField = 16777216, n._settledValueField = t, this._promiseResolved(e, n);
                            }, e.settle = function (t) {
                                return r.deprecated('.settle()', '.reflect()'), new o(t).promise();
                            }, e.prototype.settle = function () {
                                return e.settle(this);
                            };
                        };
                    }, {'./util': 36}], 31                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r) {
                            var i = t('./util'), o = t('./errors').RangeError, s = t('./errors').AggregateError, a = i.isArray, c = {};

                            function u(t) {
                                this.constructor$(t), this._howMany = 0, this._unwrap = ! 1, this._initialized = ! 1;
                            }

                            function l(t, e) {
                                if ( (0 | e) !== e || e < 0 ) return r('expecting a positive integer\n\n    See http://goo.gl/MqrFmX\n');
                                var n = new u(t), i = n.promise();
                                return n.setHowMany(e), n.init(), i;
                            }

                            i.inherits(u, n), u.prototype._init = function () {
                                if ( this._initialized ) if ( 0 !== this._howMany ) {
                                    this._init$(void 0, - 5);
                                    var t = a(this._values);
                                    ! this._isResolved() && t && this._howMany > this._canPossiblyFulfill() && this._reject(this._getRangeError(this.length()));
                                } else this._resolve([]);
                            }, u.prototype.init = function () {
                                this._initialized = ! 0, this._init();
                            }, u.prototype.setUnwrap = function () {
                                this._unwrap = ! 0;
                            }, u.prototype.howMany = function () {
                                return this._howMany;
                            }, u.prototype.setHowMany = function (t) {
                                this._howMany = t;
                            }, u.prototype._promiseFulfilled = function (t) {
                                return this._addFulfilled(t), this._fulfilled() === this.howMany() && (this._values.length = this.howMany(), 1 === this.howMany() && this._unwrap ? this._resolve(this._values[0]) : this._resolve(this._values), ! 0);
                            }, u.prototype._promiseRejected = function (t) {
                                return this._addRejected(t), this._checkOutcome();
                            }, u.prototype._promiseCancelled = function () {
                                return this._values instanceof e || null == this._values ? this._cancel() : (this._addRejected(c), this._checkOutcome());
                            }, u.prototype._checkOutcome = function () {
                                if ( this.howMany() > this._canPossiblyFulfill() ) {
                                    for (var t = new s, e = this.length(); e < this._values.length; ++ e) this._values[e] !== c && t.push(this._values[e]);
                                    return t.length > 0 ? this._reject(t) : this._cancel(), ! 0;
                                }
                                return ! 1;
                            }, u.prototype._fulfilled = function () {
                                return this._totalResolved;
                            }, u.prototype._rejected = function () {
                                return this._values.length - this.length();
                            }, u.prototype._addRejected = function (t) {
                                this._values.push(t);
                            }, u.prototype._addFulfilled = function (t) {
                                this._values[this._totalResolved ++] = t;
                            }, u.prototype._canPossiblyFulfill = function () {
                                return this.length() - this._rejected();
                            }, u.prototype._getRangeError = function (t) {
                                var e = 'Input array must contain at least ' + this._howMany + ' items but contains only ' + t + ' items';
                                return new o(e);
                            }, u.prototype._resolveEmptyArray = function () {
                                this._reject(this._getRangeError(0));
                            }, e.some = function (t, e) {
                                return l(t, e);
                            }, e.prototype.some = function (t) {
                                return l(this, t);
                            }, e._SomePromiseArray = u;
                        };
                    }, {'./errors': 12, './util': 36}], 32                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (t) {
                            function e(t) {
                                void 0 !== t ? (t = t._target(), this._bitField = t._bitField, this._settledValueField = t._isFateSealed() ? t._settledValue() : void 0) : (this._bitField = 0, this._settledValueField = void 0);
                            }

                            e.prototype._settledValue = function () {
                                return this._settledValueField;
                            };
                            var n = e.prototype.value = function () {
                                if ( ! this.isFulfilled() ) throw new TypeError('cannot get fulfillment value of a non-fulfilled promise\n\n    See http://goo.gl/MqrFmX\n');
                                return this._settledValue();
                            }, r  = e.prototype.error = e.prototype.reason = function () {
                                if ( ! this.isRejected() ) throw new TypeError('cannot get rejection reason of a non-rejected promise\n\n    See http://goo.gl/MqrFmX\n');
                                return this._settledValue();
                            }, i  = e.prototype.isFulfilled = function () {
                                return 0 !== (33554432 & this._bitField);
                            }, o  = e.prototype.isRejected = function () {
                                return 0 !== (16777216 & this._bitField);
                            }, s  = e.prototype.isPending = function () {
                                return 0 === (50397184 & this._bitField);
                            }, a  = e.prototype.isResolved = function () {
                                return 0 !== (50331648 & this._bitField);
                            };
                            e.prototype.isCancelled = function () {
                                return 0 !== (8454144 & this._bitField);
                            }, t.prototype.__isCancelled = function () {
                                return 65536 === (65536 & this._bitField);
                            }, t.prototype._isCancelled = function () {
                                return this._target().__isCancelled();
                            }, t.prototype.isCancelled = function () {
                                return 0 !== (8454144 & this._target()._bitField);
                            }, t.prototype.isPending = function () {
                                return s.call(this._target());
                            }, t.prototype.isRejected = function () {
                                return o.call(this._target());
                            }, t.prototype.isFulfilled = function () {
                                return i.call(this._target());
                            }, t.prototype.isResolved = function () {
                                return a.call(this._target());
                            }, t.prototype.value = function () {
                                return n.call(this._target());
                            }, t.prototype.reason = function () {
                                var t = this._target();
                                return t._unsetRejectionIsUnhandled(), r.call(t);
                            }, t.prototype._value = function () {
                                return this._settledValue();
                            }, t.prototype._reason = function () {
                                return this._unsetRejectionIsUnhandled(), this._settledValue();
                            }, t.PromiseInspection = e;
                        };
                    }, {}], 33                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n) {
                            var r = t('./util'), o = r.errorObj, s = r.isObject;
                            var a = {}.hasOwnProperty;
                            return function (t, c) {
                                if ( s(t) ) {
                                    if ( t instanceof e ) return t;
                                    var u = function (t) {
                                        try {
                                            return function (t) {
                                                return t.then;
                                            }(t);
                                        } catch (i) {
                                            return o.e = i, o;
                                        }
                                    }(t);
                                    if ( u === o ) {
                                        c && c._pushContext();
                                        var l = e.reject(u.e);
                                        return c && c._popContext(), l;
                                    }
                                    if ( 'function' === typeof u ) return function (t) {
                                        try {
                                            return a.call(t, '_promise0');
                                        } catch (i) {
                                            return ! 1;
                                        }
                                    }(t) ? (l = new e(n), t._then(l._fulfill, l._reject, void 0, l, null), l) : function (t, i, s) {
                                        var a = new e(n), c = a;
                                        s && s._pushContext(), a._captureStackTrace(), s && s._popContext();
                                        var u = ! 0, l = r.tryCatch(i).call(t, function (t) {
                                            a && (a._resolveCallback(t), a = null);
                                        }, function (t) {
                                            a && (a._rejectCallback(t, u, ! 0), a = null);
                                        });
                                        return u = ! 1, a && l === o && (a._rejectCallback(l.e, ! 0, ! 0), a = null), c;
                                    }(t, u, c);
                                }
                                return t;
                            };
                        };
                    }, {'./util': 36}], 34                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r) {
                            var i = t('./util'), o = e.TimeoutError;

                            function s(t) {
                                this.handle = t;
                            }

                            s.prototype._resultCancelled = function () {
                                clearTimeout(this.handle);
                            };
                            var a = function (t) {
                                return c(+ this).thenReturn(t);
                            }, c  = e.delay = function (t, i) {
                                var o, c;
                                return void 0 !== i ? (o = e.resolve(i)._then(a, null, null, t, void 0), r.cancellation() && i instanceof e && o._setOnCancel(i)) : (o = new e(n), c = setTimeout(function () {
                                    o._fulfill();
                                }, + t), r.cancellation() && o._setOnCancel(new s(c)), o._captureStackTrace()), o._setAsyncGuaranteed(), o;
                            };
                            e.prototype.delay = function (t) {
                                return c(t, this);
                            };

                            function u(t) {
                                return clearTimeout(this.handle), t;
                            }

                            function l(t) {
                                throw clearTimeout(this.handle), t;
                            }

                            e.prototype.timeout = function (t, e) {
                                var n, a;
                                t = + t;
                                var c = new s(setTimeout(function () {
                                    n.isPending() && function (t, e, n) {
                                        var r;
                                        r = 'string' !== typeof e ? e instanceof Error ? e : new o('operation timed out') : new o(e), i.markAsOriginatingFromRejection(r), t._attachExtraTrace(r), t._reject(r), null != n && n.cancel();
                                    }(n, e, a);
                                }, t));
                                return r.cancellation() ? (a = this.then(), (n = a._then(u, l, void 0, c, void 0))._setOnCancel(c)) : n = this._then(u, l, void 0, c, void 0), n;
                            };
                        };
                    }, {'./util': 36}], 35                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, e, n) {
                        'use strict';
                        e.exports = function (e, n, r, o, s, a) {
                            var c = t('./util'), u = t('./errors').TypeError, l = t('./util').inherits, f = c.errorObj, p = c.tryCatch, h = {};

                            function d(t) {
                                setTimeout(function () {
                                    throw t;
                                }, 0);
                            }

                            function _(t, n) {
                                var o = 0, a = t.length, c = new e(s);
                                return function s() {
                                    if ( o >= a ) return c._fulfill();
                                    var u = function (t) {
                                        var e = r(t);
                                        return e !== t && 'function' === typeof t._isDisposable && 'function' === typeof t._getDisposer && t._isDisposable() && e._setDisposable(t._getDisposer()), e;
                                    }(t[o ++]);
                                    if ( u instanceof e && u._isDisposable() ) {
                                        try {
                                            u = r(u._getDisposer().tryDispose(n), t.promise);
                                        } catch (i) {
                                            return d(i);
                                        }
                                        if ( u instanceof e ) return u._then(s, d, null, null, null);
                                    }
                                    s();
                                }(), c;
                            }

                            function v(t, e, n) {
                                this._data = t, this._promise = e, this._context = n;
                            }

                            function y(t, e, n) {
                                this.constructor$(t, e, n);
                            }

                            function m(t) {
                                return v.isDisposer(t) ? (this.resources[this.index]._setDisposable(t), t.promise()) : t;
                            }

                            function g(t) {
                                this.length = t, this.promise = null, this[t - 1] = null;
                            }

                            v.prototype.data = function () {
                                return this._data;
                            }, v.prototype.promise = function () {
                                return this._promise;
                            }, v.prototype.resource = function () {
                                return this.promise().isFulfilled() ? this.promise().value() : h;
                            }, v.prototype.tryDispose = function (t) {
                                var e = this.resource(), n = this._context;
                                void 0 !== n && n._pushContext();
                                var r = e !== h ? this.doDispose(e, t) : null;
                                return void 0 !== n && n._popContext(), this._promise._unsetDisposable(), this._data = null, r;
                            }, v.isDisposer = function (t) {
                                return null != t && 'function' === typeof t.resource && 'function' === typeof t.tryDispose;
                            }, l(y, v), y.prototype.doDispose = function (t, e) {
                                return this.data().call(t, t, e);
                            }, g.prototype._resultCancelled = function () {
                                for (var t = this.length, n = 0; n < t; ++ n) {
                                    var r = this[n];
                                    r instanceof e && r.cancel();
                                }
                            }, e.using = function () {
                                var t = arguments.length;
                                if ( t < 2 ) return n('you must pass at least 2 arguments to Promise.using');
                                var i, o = arguments[t - 1];
                                if ( 'function' !== typeof o ) return n('expecting a function but got ' + c.classString(o));
                                var s = ! 0;
                                2 === t && Array.isArray(arguments[0]) ? (t = (i = arguments[0]).length, s = ! 1) : (i = arguments, t --);
                                for (var u = new g(t), l = 0; l < t; ++ l) {
                                    var h = i[l];
                                    if ( v.isDisposer(h) ) {
                                        var d = h;
                                        (h = h.promise())._setDisposable(d);
                                    } else {
                                        var y = r(h);
                                        y instanceof e && (h = y._then(m, null, null, {resources: u, index: l}, void 0));
                                    }
                                    u[l] = h;
                                }
                                var b = new Array(u.length);
                                for (l = 0; l < b.length; ++ l) b[l] = e.resolve(u[l]).reflect();
                                var C = e.all(b).then(function (t) {
                                    for (var e = 0; e < t.length; ++ e) {
                                        var n = t[e];
                                        if ( n.isRejected() ) return f.e = n.error(), f;
                                        if ( ! n.isFulfilled() ) return void C.cancel();
                                        t[e] = n.value();
                                    }
                                    w._pushContext(), o = p(o);
                                    var r = s ? o.apply(void 0, t) : o(t), i = w._popContext();
                                    return a.checkForgottenReturns(r, i, 'Promise.using', w), r;
                                }), w = C.lastly(function () {
                                    var t = new e.PromiseInspection(C);
                                    return _(u, t);
                                });
                                return u.promise = w, w._setOnCancel(u), w;
                            }, e.prototype._setDisposable = function (t) {
                                this._bitField = 131072 | this._bitField, this._disposer = t;
                            }, e.prototype._isDisposable = function () {
                                return (131072 & this._bitField) > 0;
                            }, e.prototype._getDisposer = function () {
                                return this._disposer;
                            }, e.prototype._unsetDisposable = function () {
                                this._bitField = - 131073 & this._bitField, this._disposer = void 0;
                            }, e.prototype.disposer = function (t) {
                                if ( 'function' === typeof t ) return new y(t, this, o());
                                throw new u;
                            };
                        };
                    }, {'./errors': 12, './util': 36}], 36                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            : [function (t, r, o) {
                        'use strict';
                        var s = t('./es5'), a = 'undefined' == typeof navigator, c = {e: {}}, u, l = 'undefined' !== typeof self ? self : 'undefined' !== typeof window ? window : 'undefined' !== typeof n ? n : void 0 !== this ? this : null;

                        function f() {
                            try {
                                var t = u;
                                return u = null, t.apply(this, arguments);
                            } catch (i) {
                                return c.e = i, c;
                            }
                        }

                        function p(t) {
                            return u = t, f;
                        }

                        var h = function (t, e) {
                            var n = {}.hasOwnProperty;

                            function r() {
                                for (var r in this.constructor = t, this.constructor$ = e, e.prototype) n.call(e.prototype, r) && '$' !== r.charAt(r.length - 1) && (this[r + '$'] = e.prototype[r]);
                            }

                            return r.prototype = e.prototype, t.prototype = new r, t.prototype;
                        };

                        function d(t) {
                            return null == t || ! 0 === t || ! 1 === t || 'string' === typeof t || 'number' === typeof t;
                        }

                        function _(t) {
                            return 'function' === typeof t || 'object' === typeof t && null !== t;
                        }

                        function v(t) {
                            return d(t) ? new Error(T(t)) : t;
                        }

                        function y(t, e) {
                            var n, r = t.length, i = new Array(r + 1);
                            for (n = 0; n < r; ++ n) i[n] = t[n];
                            return i[n] = e, i;
                        }

                        function m(t, e, n) {
                            if ( ! s.isES5 ) return {}.hasOwnProperty.call(t, e) ? t[e] : void 0;
                            var r = Object.getOwnPropertyDescriptor(t, e);
                            return null != r ? null == r.get && null == r.set ? r.value : n : void 0;
                        }

                        function g(t, e, n) {
                            if ( d(t) ) return t;
                            var r = {value: n, configurable: ! 0, enumerable: ! 1, writable: ! 0};
                            return s.defineProperty(t, e, r), t;
                        }

                        function b(t) {
                            throw t;
                        }

                        var C  = function () {
                            var t = [Array.prototype, Object.prototype, Function.prototype], e = function (e) {
                                for (var n = 0; n < t.length; ++ n) if ( t[n] === e ) return ! 0;
                                return ! 1;
                            };
                            if ( s.isES5 ) {
                                var n = Object.getOwnPropertyNames;
                                return function (t) {
                                    for (var r = [], o = Object.create(null); null != t && ! e(t);) {
                                        var a;
                                        try {
                                            a = n(t);
                                        } catch (i) {
                                            return r;
                                        }
                                        for (var c = 0; c < a.length; ++ c) {
                                            var u = a[c];
                                            if ( ! o[u] ) {
                                                o[u] = ! 0;
                                                var l = Object.getOwnPropertyDescriptor(t, u);
                                                null != l && null == l.get && null == l.set && r.push(u);
                                            }
                                        }
                                        t = s.getPrototypeOf(t);
                                    }
                                    return r;
                                };
                            }
                            var r = {}.hasOwnProperty;
                            return function (n) {
                                if ( e(n) ) return [];
                                var i = [];
                                t:for (var o in n) if ( r.call(n, o) ) i.push(o); else {
                                    for (var s = 0; s < t.length; ++ s) if ( r.call(t[s], o) ) continue t;
                                    i.push(o);
                                }
                                return i;
                            };
                        }(), w = /this\s*\.\s*\S+\s*=/;

                        function j(t) {
                            try {
                                if ( 'function' === typeof t ) {
                                    var e = s.names(t.prototype), n = s.isES5 && e.length > 1, r = e.length > 0 && ! (1 === e.length && 'constructor' === e[0]), o = w.test(t + '') && s.names(t).length > 0;
                                    if ( n || r || o ) return ! 0;
                                }
                                return ! 1;
                            } catch (i) {
                                return ! 1;
                            }
                        }

                        function F(t) {
                            function e() {
                            }

                            e.prototype = t;
                            var n = new e;

                            function r() {
                                return typeof n.foo;
                            }

                            return r(), r(), t;
                        }

                        var k = /^[a-z$_][a-z$_0-9]*$/i;

                        function E(t) {
                            return k.test(t);
                        }

                        function x(t, e, n) {
                            for (var r = new Array(t), i = 0; i < t; ++ i) r[i] = e + i + n;
                            return r;
                        }

                        function T(t) {
                            try {
                                return t + '';
                            } catch (i) {
                                return '[no string representation]';
                            }
                        }

                        function P(t) {
                            return t instanceof Error || null !== t && 'object' === typeof t && 'string' === typeof t.message && 'string' === typeof t.name;
                        }

                        function O(t) {
                            try {
                                g(t, 'isOperational', ! 0);
                            } catch (e) {
                            }
                        }

                        function S(t) {
                            return null != t && (t instanceof Error.__BluebirdErrorTypes__.OperationalError || ! 0 === t.isOperational);
                        }

                        function R(t) {
                            return P(t) && s.propertyIsWritable(t, 'stack');
                        }

                        var A = 'stack' in new Error ? function (t) {
                            return R(t) ? t : new Error(T(t));
                        } : function (t) {
                            if ( R(t) ) return t;
                            try {
                                throw new Error(T(t));
                            } catch (e) {
                                return e;
                            }
                        };

                        function I(t) {
                            return {}.toString.call(t);
                        }

                        function N(t, e, n) {
                            for (var r = s.names(t), i = 0; i < r.length; ++ i) {
                                var o = r[i];
                                if ( n(o) ) try {
                                    s.defineProperty(e, o, s.getDescriptor(t, o));
                                } catch (a) {
                                }
                            }
                        }

                        var D = function (t) {
                            return s.isArray(t) ? t : null;
                        };
                        if ( 'undefined' !== typeof Symbol && Symbol.iterator ) {
                            var L = 'function' === typeof Array.from ? function (t) {
                                return Array.from(t);
                            } : function (t) {
                                for (var e, n = [], r = t[Symbol.iterator](); ! (e = r.next()).done;) n.push(e.value);
                                return n;
                            };
                            D = function (t) {
                                return s.isArray(t) ? t : null != t && 'function' === typeof t[Symbol.iterator] ? L(t) : null;
                            };
                        }
                        var V = 'undefined' !== typeof e && '[object process]' === I(e).toLowerCase(), M = 'undefined' !== typeof e && ! 0;

                        function U(t) {
                            return M ? Object({NODE_ENV: 'production'})[t] : void 0;
                        }

                        function B() {
                            if ( 'function' === typeof Promise ) try {
                                var t = new Promise(function () {
                                });
                                if ( '[object Promise]' === {}.toString.call(t) ) return Promise;
                            } catch (i) {
                            }
                        }

                        function H(t, e) {
                            return t.bind(e);
                        }

                        var q = {isClass: j, isIdentifier: E, inheritedDataKeys: C, getDataPropertyOrDefault: m, thrower: b, isArray: s.isArray, asArray: D, notEnumerableProp: g, isPrimitive: d, isObject: _, isError: P, canEvaluate: a, errorObj: c, tryCatch: p, inherits: h, withAppended: y, maybeWrapAsError: v, toFastProperties: F, filledRange: x, toString: T, canAttachTrace: R, ensureErrorObject: A, originatesFromRejection: S, markAsOriginatingFromRejection: O, classString: I, copyDescriptors: N, hasDevTools: 'undefined' !== typeof chrome && chrome && 'function' === typeof chrome.loadTimes, isNode: V, hasEnvVariables: M, env: U, global: l, getNativePromise: B, domainBind: H};
                        q.isRecentNode = q.isNode && function () {
                            var t = e.versions.node.split('.').map(Number);
                            return 0 === t[0] && t[1] > 10 || t[0] > 0;
                        }(), q.isNode && q.toFastProperties(e);
                        try {
                            throw new Error;
                        } catch (i) {
                            q.lastLineError = i;
                        }
                        r.exports = q;
                    }, {'./es5': 13}]
                }, {}, [4])(4);
            }, t.exports = i(), 'undefined' !== typeof window && null !== window ? window.P = window.Promise : 'undefined' !== typeof self && null !== self && (self.P = self.Promise);
        }).call(this, n('../node_modules/process/browser.js'), n('../node_modules/webpack/buildin/global.js'), n('../node_modules/timers-browserify/main.js').setImmediate);
    }, '../node_modules/ms/index.js'                    : function (t, e) {
        var n = 1e3, r = 60 * n, i = 60 * r, o = 24 * i, s = 7 * o, a = 365.25 * o;

        function c(t, e, n, r) {
            var i = e >= 1.5 * n;
            return Math.round(t / n) + ' ' + r + (i ? 's' : '');
        }

        t.exports = function (t, e) {
            e = e || {};
            var u = typeof t;
            if ( 'string' === u && t.length > 0 ) return function (t) {
                if ( (t = String(t)).length > 100 ) return;
                var e = /^((?:\d+)?\-?\d?\.?\d+) *(milliseconds?|msecs?|ms|seconds?|secs?|s|minutes?|mins?|m|hours?|hrs?|h|days?|d|weeks?|w|years?|yrs?|y)?$/i.exec(t);
                if ( ! e ) return;
                var c = parseFloat(e[1]);
                switch ((e[2] || 'ms').toLowerCase()) {
                    case'years':
                    case'year':
                    case'yrs':
                    case'yr':
                    case'y':
                        return c * a;
                    case'weeks':
                    case'week':
                    case'w':
                        return c * s;
                    case'days':
                    case'day':
                    case'd':
                        return c * o;
                    case'hours':
                    case'hour':
                    case'hrs':
                    case'hr':
                    case'h':
                        return c * i;
                    case'minutes':
                    case'minute':
                    case'mins':
                    case'min':
                    case'm':
                        return c * r;
                    case'seconds':
                    case'second':
                    case'secs':
                    case'sec':
                    case's':
                        return c * n;
                    case'milliseconds':
                    case'millisecond':
                    case'msecs':
                    case'msec':
                    case'ms':
                        return c;
                    default:
                        return;
                }
            }(t);
            if ( 'number' === u && ! 1 === isNaN(t) ) return e.long ? function (t) {
                var e = Math.abs(t);
                if ( e >= o ) return c(t, e, o, 'day');
                if ( e >= i ) return c(t, e, i, 'hour');
                if ( e >= r ) return c(t, e, r, 'minute');
                if ( e >= n ) return c(t, e, n, 'second');
                return t + ' ms';
            }(t) : function (t) {
                var e = Math.abs(t);
                if ( e >= o ) return Math.round(t / o) + 'd';
                if ( e >= i ) return Math.round(t / i) + 'h';
                if ( e >= r ) return Math.round(t / r) + 'm';
                if ( e >= n ) return Math.round(t / n) + 's';
                return t + 'ms';
            }(t);
            throw new Error('val is not a non-empty string or a valid number. val=' + JSON.stringify(t));
        };
    }, '../node_modules/process/browser.js'             : function (t, e) {
        var n, r, i = t.exports = {};

        function o() {
            throw new Error('setTimeout has not been defined');
        }

        function s() {
            throw new Error('clearTimeout has not been defined');
        }

        function a(t) {
            if ( n === setTimeout ) return setTimeout(t, 0);
            if ( (n === o || ! n) && setTimeout ) return n = setTimeout, setTimeout(t, 0);
            try {
                return n(t, 0);
            } catch (e) {
                try {
                    return n.call(null, t, 0);
                } catch (e) {
                    return n.call(this, t, 0);
                }
            }
        }

        ! function () {
            try {
                n = 'function' === typeof setTimeout ? setTimeout : o;
            } catch (t) {
                n = o;
            }
            try {
                r = 'function' === typeof clearTimeout ? clearTimeout : s;
            } catch (t) {
                r = s;
            }
        }();
        var c, u = [], l = ! 1, f = - 1;

        function p() {
            l && c && (l = ! 1, c.length ? u = c.concat(u) : f = - 1, u.length && h());
        }

        function h() {
            if ( ! l ) {
                var t = a(p);
                l = ! 0;
                for (var e = u.length; e;) {
                    for (c = u, u = []; ++ f < e;) c && c[f].run();
                    f = - 1, e = u.length;
                }
                c = null, l = ! 1, function (t) {
                    if ( r === clearTimeout ) return clearTimeout(t);
                    if ( (r === s || ! r) && clearTimeout ) return r = clearTimeout, clearTimeout(t);
                    try {
                        r(t);
                    } catch (e) {
                        try {
                            return r.call(null, t);
                        } catch (e) {
                            return r.call(this, t);
                        }
                    }
                }(t);
            }
        }

        function d(t, e) {
            this.fun = t, this.array = e;
        }

        function _() {
        }

        i.nextTick = function (t) {
            var e = new Array(arguments.length - 1);
            if ( arguments.length > 1 ) for (var n = 1; n < arguments.length; n ++) e[n - 1] = arguments[n];
            u.push(new d(t, e)), 1 !== u.length || l || a(h);
        }, d.prototype.run = function () {
            this.fun.apply(null, this.array);
        }, i.title = 'browser', i.browser = ! 0, i.env = {}, i.argv = [], i.version = '', i.versions = {}, i.on = _, i.addListener = _, i.once = _, i.off = _, i.removeListener = _, i.removeAllListeners = _, i.emit = _, i.prependListener = _, i.prependOnceListener = _, i.listeners = function (t) {
            return [];
        }, i.binding = function (t) {
            throw new Error('process.binding is not supported');
        }, i.cwd = function () {
            return '/';
        }, i.chdir = function (t) {
            throw new Error('process.chdir is not supported');
        }, i.umask = function () {
            return 0;
        };
    }, '../node_modules/querystring-es3/decode.js'      : function (t, e, n) {
        'use strict';

        function r(t, e) {
            return Object.prototype.hasOwnProperty.call(t, e);
        }

        t.exports = function (t, e, n, o) {
            e = e || '&', n = n || '=';
            var s = {};
            if ( 'string' !== typeof t || 0 === t.length ) return s;
            var a = /\+/g;
            t = t.split(e);
            var c = 1e3;
            o && 'number' === typeof o.maxKeys && (c = o.maxKeys);
            var u = t.length;
            c > 0 && u > c && (u = c);
            for (var l = 0; l < u; ++ l) {
                var f, p, h, d, _ = t[l].replace(a, '%20'), v = _.indexOf(n);
                v >= 0 ? (f = _.substr(0, v), p = _.substr(v + 1)) : (f = _, p = ''), h = decodeURIComponent(f), d = decodeURIComponent(p), r(s, h) ? i(s[h]) ? s[h].push(d) : s[h] = [s[h], d] : s[h] = d;
            }
            return s;
        };
        var i = Array.isArray || function (t) {
            return '[object Array]' === Object.prototype.toString.call(t);
        };
    }, '../node_modules/querystring-es3/encode.js'      : function (t, e, n) {
        'use strict';
        var r = function (t) {
            switch (typeof t) {
                case'string':
                    return t;
                case'boolean':
                    return t ? 'true' : 'false';
                case'number':
                    return isFinite(t) ? t : '';
                default:
                    return '';
            }
        };
        t.exports = function (t, e, n, a) {
            return e = e || '&', n = n || '=', null === t && (t = void 0), 'object' === typeof t ? o(s(t), function (s) {
                var a = encodeURIComponent(r(s)) + n;
                return i(t[s]) ? o(t[s], function (t) {
                    return a + encodeURIComponent(r(t));
                }).join(e) : a + encodeURIComponent(r(t[s]));
            }).join(e) : a ? encodeURIComponent(r(a)) + n + encodeURIComponent(r(t)) : '';
        };
        var i = Array.isArray || function (t) {
            return '[object Array]' === Object.prototype.toString.call(t);
        };

        function o(t, e) {
            if ( t.map ) return t.map(e);
            for (var n = [], r = 0; r < t.length; r ++) n.push(e(t[r], r));
            return n;
        }

        var s = Object.keys || function (t) {
            var e = [];
            for (var n in t) Object.prototype.hasOwnProperty.call(t, n) && e.push(n);
            return e;
        };
    }, '../node_modules/querystring-es3/index.js'       : function (t, e, n) {
        'use strict';
        e.decode = e.parse = n('../node_modules/querystring-es3/decode.js'), e.encode = e.stringify = n('../node_modules/querystring-es3/encode.js');
    }, '../node_modules/setimmediate/setImmediate.js'   : function (t, e, n) {
        (function (t, e) {
            ! function (t, n) {
                'use strict';
                if ( ! t.setImmediate ) {
                    var r, i = 1, o = {}, s = ! 1, a = t.document, c = Object.getPrototypeOf && Object.getPrototypeOf(t);
                    c = c && c.setTimeout ? c : t, '[object process]' === {}.toString.call(t.process) ? r = function (t) {
                        e.nextTick(function () {
                            l(t);
                        });
                    } : function () {
                        if ( t.postMessage && ! t.importScripts ) {
                            var e = ! 0, n = t.onmessage;
                            return t.onmessage = function () {
                                e = ! 1;
                            }, t.postMessage('', '*'), t.onmessage = n, e;
                        }
                    }() ? function () {
                        var e = 'setImmediate$' + Math.random() + '$', n = function (n) {
                            n.source === t && 'string' === typeof n.data && 0 === n.data.indexOf(e) && l(+ n.data.slice(e.length));
                        };
                        t.addEventListener ? t.addEventListener('message', n, ! 1) : t.attachEvent('onmessage', n), r = function (n) {
                            t.postMessage(e + n, '*');
                        };
                    }() : t.MessageChannel ? function () {
                        var t = new MessageChannel;
                        t.port1.onmessage = function (t) {
                            l(t.data);
                        }, r = function (e) {
                            t.port2.postMessage(e);
                        };
                    }() : a && 'onreadystatechange' in a.createElement('script') ? function () {
                        var t = a.documentElement;
                        r = function (e) {
                            var n = a.createElement('script');
                            n.onreadystatechange = function () {
                                l(e), n.onreadystatechange = null, t.removeChild(n), n = null;
                            }, t.appendChild(n);
                        };
                    }() : r = function (t) {
                        setTimeout(l, 0, t);
                    }, c.setImmediate = function (t) {
                        'function' !== typeof t && (t = new Function('' + t));
                        for (var e = new Array(arguments.length - 1), n = 0; n < e.length; n ++) e[n] = arguments[n + 1];
                        var s = {callback: t, args: e};
                        return o[i] = s, r(i), i ++;
                    }, c.clearImmediate = u;
                }

                function u(t) {
                    delete o[t];
                }

                function l(t) {
                    if ( s ) setTimeout(l, 0, t); else {
                        var e = o[t];
                        if ( e ) {
                            s = ! 0;
                            try {
                                ! function (t) {
                                    var e = t.callback, r = t.args;
                                    switch (r.length) {
                                        case 0:
                                            e();
                                            break;
                                        case 1:
                                            e(r[0]);
                                            break;
                                        case 2:
                                            e(r[0], r[1]);
                                            break;
                                        case 3:
                                            e(r[0], r[1], r[2]);
                                            break;
                                        default:
                                            e.apply(n, r);
                                    }
                                }(e);
                            } finally {
                                u(t), s = ! 1;
                            }
                        }
                    }
                }
            }('undefined' === typeof self ? 'undefined' === typeof t ? this : t : self);
        }).call(this, n('../node_modules/webpack/buildin/global.js'), n('../node_modules/process/browser.js'));
    }, '../node_modules/timers-browserify/main.js'      : function (t, e, n) {
        (function (t) {
            var r = 'undefined' !== typeof t && t || 'undefined' !== typeof self && self || window, i = Function.prototype.apply;

            function o(t, e) {
                this._id = t, this._clearFn = e;
            }

            e.setTimeout = function () {
                return new o(i.call(setTimeout, r, arguments), clearTimeout);
            }, e.setInterval = function () {
                return new o(i.call(setInterval, r, arguments), clearInterval);
            }, e.clearTimeout = e.clearInterval = function (t) {
                t && t.close();
            }, o.prototype.unref = o.prototype.ref = function () {
            }, o.prototype.close = function () {
                this._clearFn.call(r, this._id);
            }, e.enroll = function (t, e) {
                clearTimeout(t._idleTimeoutId), t._idleTimeout = e;
            }, e.unenroll = function (t) {
                clearTimeout(t._idleTimeoutId), t._idleTimeout = - 1;
            }, e._unrefActive = e.active = function (t) {
                clearTimeout(t._idleTimeoutId);
                var e = t._idleTimeout;
                e >= 0 && (t._idleTimeoutId = setTimeout(function () {
                    t._onTimeout && t._onTimeout();
                }, e));
            }, n('../node_modules/setimmediate/setImmediate.js'), e.setImmediate = 'undefined' !== typeof self && self.setImmediate || 'undefined' !== typeof t && t.setImmediate || this && this.setImmediate, e.clearImmediate = 'undefined' !== typeof self && self.clearImmediate || 'undefined' !== typeof t && t.clearImmediate || this && this.clearImmediate;
        }).call(this, n('../node_modules/webpack/buildin/global.js'));
    }, '../node_modules/webpack/buildin/global.js'      : function (t, e) {
        var n;
        n = function () {
            return this;
        }();
        try {
            n = n || new Function('return this')();
        } catch (r) {
            'object' === typeof window && (n = window);
        }
        t.exports = n;
    }, './node_modules/debug/src/browser.js'            : function (t, e, n) {
        'use strict';
        (function (r) {
            function i(t) {
                return (i = 'function' === typeof Symbol && 'symbol' === typeof Symbol.iterator ? function (t) {
                    return typeof t;
                } : function (t) {
                    return t && 'function' === typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? 'symbol' : typeof t;
                })(t);
            }

            e.log = function () {
                var t;
                return 'object' === ('undefined' === typeof console ? 'undefined' : i(console)) && console.log && (t = console).log.apply(t, arguments);
            }, e.formatArgs = function (e) {
                if ( e[0] = (this.useColors ? '%c' : '') + this.namespace + (this.useColors ? ' %c' : ' ') + e[0] + (this.useColors ? '%c ' : ' ') + '+' + t.exports.humanize(this.diff), ! this.useColors ) return;
                var n = 'color: ' + this.color;
                e.splice(1, 0, n, 'color: inherit');
                var r = 0, i = 0;
                e[0].replace(/%[a-zA-Z%]/g, function (t) {
                    '%%' !== t && (r ++, '%c' === t && (i = r));
                }), e.splice(i, 0, n);
            }, e.save = function (t) {
                try {
                    t ? e.storage.setItem('debug', t) : e.storage.removeItem('debug');
                } catch (n) {
                }
            }, e.load = function () {
                var t;
                try {
                    t = e.storage.getItem('debug');
                } catch (n) {
                }
                ! t && 'undefined' !== typeof r && 'env' in r && (t = Object({NODE_ENV: 'production'}).DEBUG);
                return t;
            }, e.useColors = function () {
                if ( 'undefined' !== typeof window && window.process && ('renderer' === window.process.type || window.process.__nwjs) ) return ! 0;
                if ( 'undefined' !== typeof navigator && navigator.userAgent && navigator.userAgent.toLowerCase().match(/(edge|trident)\/(\d+)/) ) return ! 1;
                return 'undefined' !== typeof document && document.documentElement && document.documentElement.style && document.documentElement.style.WebkitAppearance || 'undefined' !== typeof window && window.console && (window.console.firebug || window.console.exception && window.console.table) || 'undefined' !== typeof navigator && navigator.userAgent && navigator.userAgent.toLowerCase().match(/firefox\/(\d+)/) && parseInt(RegExp.$1, 10) >= 31 || 'undefined' !== typeof navigator && navigator.userAgent && navigator.userAgent.toLowerCase().match(/applewebkit\/(\d+)/);
            }, e.storage = function () {
                try {
                    return localStorage;
                } catch (t) {
                }
            }(), e.colors = ['#0000CC', '#0000FF', '#0033CC', '#0033FF', '#0066CC', '#0066FF', '#0099CC', '#0099FF', '#00CC00', '#00CC33', '#00CC66', '#00CC99', '#00CCCC', '#00CCFF', '#3300CC', '#3300FF', '#3333CC', '#3333FF', '#3366CC', '#3366FF', '#3399CC', '#3399FF', '#33CC00', '#33CC33', '#33CC66', '#33CC99', '#33CCCC', '#33CCFF', '#6600CC', '#6600FF', '#6633CC', '#6633FF', '#66CC00', '#66CC33', '#9900CC', '#9900FF', '#9933CC', '#9933FF', '#99CC00', '#99CC33', '#CC0000', '#CC0033', '#CC0066', '#CC0099', '#CC00CC', '#CC00FF', '#CC3300', '#CC3333', '#CC3366', '#CC3399', '#CC33CC', '#CC33FF', '#CC6600', '#CC6633', '#CC9900', '#CC9933', '#CCCC00', '#CCCC33', '#FF0000', '#FF0033', '#FF0066', '#FF0099', '#FF00CC', '#FF00FF', '#FF3300', '#FF3333', '#FF3366', '#FF3399', '#FF33CC', '#FF33FF', '#FF6600', '#FF6633', '#FF9900', '#FF9933', '#FFCC00', '#FFCC33'], t.exports = n('./node_modules/debug/src/common.js')(e), t.exports.formatters.j = function (t) {
                try {
                    return JSON.stringify(t);
                } catch (e) {
                    return '[UnexpectedJSONParseError]: ' + e.message;
                }
            };
        }).call(this, n('../node_modules/process/browser.js'));
    }, './node_modules/debug/src/common.js'             : function (t, e, n) {
        'use strict';
        t.exports = function (t) {
            function e(t) {
                for (var e = 0, n = 0; n < t.length; n ++) e = (e << 5) - e + t.charCodeAt(n), e |= 0;
                return r.colors[Math.abs(e) % r.colors.length];
            }

            function r(t) {
                var n;

                function s() {
                    if ( s.enabled ) {
                        for (var t = arguments.length, e = new Array(t), i = 0; i < t; i ++) e[i] = arguments[i];
                        var o = s, a = Number(new Date), c = a - (n || a);
                        o.diff = c, o.prev = n, o.curr = a, n = a, e[0] = r.coerce(e[0]), 'string' !== typeof e[0] && e.unshift('%O');
                        var u = 0;
                        e[0] = e[0].replace(/%([a-zA-Z%])/g, function (t, n) {
                            if ( '%%' === t ) return t;
                            u ++;
                            var i = r.formatters[n];
                            if ( 'function' === typeof i ) {
                                var s = e[u];
                                t = i.call(o, s), e.splice(u, 1), u --;
                            }
                            return t;
                        }), r.formatArgs.call(o, e), (o.log || r.log).apply(o, e);
                    }
                }

                return s.namespace = t, s.enabled = r.enabled(t), s.useColors = r.useColors(), s.color = e(t), s.destroy = i, s.extend = o, 'function' === typeof r.init && r.init(s), r.instances.push(s), s;
            }

            function i() {
                var t = r.instances.indexOf(this);
                return - 1 !== t && (r.instances.splice(t, 1), ! 0);
            }

            function o(t, e) {
                return r(this.namespace + ('undefined' === typeof e ? ':' : e) + t);
            }

            return r.debug = r, r.default = r, r.coerce = function (t) {
                return t instanceof Error ? t.stack || t.message : t;
            }, r.disable = function () {
                r.enable('');
            }, r.enable = function (t) {
                var e;
                r.save(t), r.names = [], r.skips = [];
                var n = ('string' === typeof t ? t : '').split(/[\s,]+/), i = n.length;
                for (e = 0; e < i; e ++) n[e] && ('-' === (t = n[e].replace(/\*/g, '.*?'))[0] ? r.skips.push(new RegExp('^' + t.substr(1) + '$')) : r.names.push(new RegExp('^' + t + '$')));
                for (e = 0; e < r.instances.length; e ++) {
                    var o = r.instances[e];
                    o.enabled = r.enabled(o.namespace);
                }
            }, r.enabled = function (t) {
                if ( '*' === t[t.length - 1] ) return ! 0;
                var e, n;
                for (e = 0, n = r.skips.length; e < n; e ++) if ( r.skips[e].test(t) ) return ! 1;
                for (e = 0, n = r.names.length; e < n; e ++) if ( r.names[e].test(t) ) return ! 0;
                return ! 1;
            }, r.humanize = n('../node_modules/ms/index.js'), Object.keys(t).forEach(function (e) {
                r[e] = t[e];
            }), r.instances = [], r.names = [], r.skips = [], r.formatters = {}, r.selectColor = e, r.enable(r.load()), r;
        };
    }, './src/comments/index.tsx'                       : function (t, e, n) {
        'use strict';
        n.r(e);
        var r = n('@codex/core'), i = function (t, e, n, r) {
            return new (n || (n = Promise))(function (i, o) {
                function s(t) {
                    try {
                        c(r.next(t));
                    } catch (e) {
                        o(e);
                    }
                }

                function a(t) {
                    try {
                        c(r.throw(t));
                    } catch (e) {
                        o(e);
                    }
                }

                function c(t) {
                    t.done ? i(t.value) : new n(function (e) {
                        e(t.value);
                    }).then(s, a);
                }

                c((r = r.apply(t, e || [])).next());
            });
        }, o  = function (t, e) {
            var n, r, i, o, s = {
                label  : 0, sent: function () {
                    if ( 1 & i[0] ) throw i[1];
                    return i[1];
                }, trys: [], ops: []
            };
            return o = {next: a(0), throw: a(1), return: a(2)}, 'function' === typeof Symbol && (o[Symbol.iterator] = function () {
                return this;
            }), o;

            function a(o) {
                return function (a) {
                    return function (o) {
                        if ( n ) throw new TypeError('Generator is already executing.');
                        for (; s;) try {
                            if ( n = 1, r && (i = 2 & o[0] ? r.return : o[0] ? r.throw || ((i = r.return) && i.call(r), 0) : r.next) && ! (i = i.call(r, o[1])).done ) return i;
                            switch (r = 0, i && (o = [2 & o[0], i.value]), o[0]) {
                                case 0:
                                case 1:
                                    i = o;
                                    break;
                                case 4:
                                    return s.label ++, {value: o[1], done: ! 1};
                                case 5:
                                    s.label ++, r = o[1], o = [0];
                                    continue;
                                case 7:
                                    o = s.ops.pop(), s.trys.pop();
                                    continue;
                                default:
                                    if ( ! (i = (i = s.trys).length > 0 && i[i.length - 1]) && (6 === o[0] || 2 === o[0]) ) {
                                        s = 0;
                                        continue;
                                    }
                                    if ( 3 === o[0] && (! i || o[1] > i[0] && o[1] < i[3]) ) {
                                        s.label = o[1];
                                        break;
                                    }
                                    if ( 6 === o[0] && s.label < i[1] ) {
                                        s.label = i[1], i = o;
                                        break;
                                    }
                                    if ( i && s.label < i[2] ) {
                                        s.label = i[2], s.ops.push(o);
                                        break;
                                    }
                                    i[2] && s.ops.pop(), s.trys.pop();
                                    continue;
                            }
                            o = e.call(t, s);
                        } catch (a) {
                            o = [6, a], r = 0;
                        } finally {
                            n = i = 0;
                        }
                        if ( 5 & o[0] ) throw o[1];
                        return {value: o[0] ? o[1] : void 0, done: ! 0};
                    }([o, a]);
                };
            }
        }, s  = ! 1;
        var a  = function () {
            var t = function (e, n) {
                return (t = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (t, e) {
                    t.__proto__ = e;
                } || function (t, e) {
                    for (var n in e) e.hasOwnProperty(n) && (t[n] = e[n]);
                })(e, n);
            };
            return function (e, n) {
                function r() {
                    this.constructor = e;
                }

                t(e, n), e.prototype = null === n ? Object.create(n) : (r.prototype = n.prototype, new r);
            };
        }(), c = (n('./node_modules/debug/src/browser.js')('comments'), 'comments'), u = function (t) {
            function e() {
                var e = null !== t && t.apply(this, arguments) || this;
                return e.name = c, e;
            }

            return a(e, t), e.prototype.install = function (t) {
                ! function () {
                    i(this, void 0, void 0, function () {
                        return o(this, function (t) {
                            return s ? [2] : (s = ! 0, [2, n.e('comments.style').then(n.t.bind(null, './src/comments/styling/codex.comments.scss', 7))]);
                        });
                    });
                }();
            }, e.prototype.register = function () {
            }, e;
        }(r.BasePlugin);
        e.default = u;
    }, './src/pre-path.js?entryName=comments'           : function (t, e, n) {
        'use strict';
        n.r(e), function (t) {
            var e = n('../node_modules/bluebird-global/index.js'), r = n.n(e), i = n('../node_modules/querystring-es3/index.js');
            r.a.config({cancellation: ! 0, warnings: ! 1});
            var o = Object(i.parse)(t.substr(1)), s = window.__CODEX_PUBLIC_PATHS || {};
            s[o.entryName] && (console.log('pre-path', o.entryName, {query: o, publicPaths: s}), n.p = s[o.entryName]);
        }.call(this, '?entryName=comments');
    }, 3                                                : function (t, e, n) {
        n('./src/pre-path.js?entryName=comments'), t.exports = n('./src/comments/index.tsx');
    }, '@codex/core'                                    : function (t, e) {
        t.exports = window.codex.core;
    }
});
